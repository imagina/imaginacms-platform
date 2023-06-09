<?php

namespace Modules\Requestable\Exports;

use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
// In testing (maybe this has performance issues with lots of data)
use Maatwebsite\Excel\Concerns\WithHeadings;
//Events
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeSheet;
//Entities
use Modules\Media\Entities\File;

//Extra

class RequestablesExport implements FromQuery, WithEvents, WithMapping, WithHeadings, ShouldQueue, ShouldAutoSize
{
    use Exportable;

    private $params;

    private $exportParams;

    private $inotification;

    private $requestableRepository;

    private $categoryRepository;

    private $category = null;

    private $fields = null;

    private $reportType = null;

    private $report = null;

    public $showExtraFields = null;

    public function __construct($params, $exportParams)
    {
        $this->params = $params;
        $this->exportParams = $exportParams;
        $this->inotification = app('Modules\Notification\Services\Inotification');
        $this->requestableRepository = app('Modules\Requestable\Repositories\RequestableRepository');
        $this->categoryRepository = app('Modules\Requestable\Repositories\CategoryRepository');

        $this->getExtraFields();

        $this->showExtraFields = (bool) setting('requestable::showExtraFieldsFromFormInReport');

        // Set report Type from Filter
        $this->reportType = $this->params->filter->reportType;

        //IMPORTANT: The reportType in the Config must be the same value to the class (exportFields)
        //Set report class
        $this->report = app('Modules\Requestable\Exports\Reports\\'.$this->reportType.'Report', ['requestableExport' => $this]);
    }

    /*
    * Get items from repository
    */
    public function query()
    {
        $this->params->onlyQuery = true;

        $order['field'] = 'id';
        $this->params->filter->order = (object) $order;

        return $this->requestableRepository->getItemsBy($this->params);
    }

    /*
    * Get Category from filter params
    */
    public function getCategory()
    {
        $filter = $this->params->filter ?? null;
        if (! is_null($filter)) {
            if (isset($filter->categoryId)) {
                $this->category = $this->categoryRepository->getItem($filter->categoryId);
            }
        }
    }

    /*
    * Get Fields from Form Category
    */
    public function getExtraFields()
    {
        // Get Category From Filter Params
        $this->getCategory();

        // Validate category and get fields from Form category
        if (! is_null($this->category) && ! is_null($this->category->form)) {
            $fieldsAll = $this->category->form->fields;
            $this->fields = $fieldsAll->map->only('name', 'label', 'type');
        }
    }

    /*
    * Get fields and add to Heading
    */
    public function addFieldsToHeading($headingFields)
    {
        if (! is_null($this->fields)) {
            foreach ($this->fields as $key => $field) {
                array_push($headingFields, rtrim(str_replace('*', '', $field['label'])));
            }
        }

        return $headingFields;
    }

    /*
    * Get fields and add to item
    */
    public function addFieldsToItem($item, $baseItem, $customFields = null)
    {
        if (! is_null($this->fields)) {
            //Testing custom fields
            $this->fields = $customFields ?? $this->fields;

            foreach ($this->fields as $key => $field) {
                $value = '--';

                /* Check if field from Form is a "file"
                and change it because in the fillable they save it as "medias_single"
                */
                if ($field['type'] == '12') {
                    $field['name'] = 'medias_single';
                }

                // Convert to snake case fields from Form
                $nameSnake = \Str::snake($field['name']);

                // Validate field exist in item
                $fieldItem = $item->fields->where('name', $nameSnake)->first();

                // Get field Value
                if (! is_null($fieldItem)) {
                    $value = $fieldItem->translations->first()->value ?? '--';

                    // Value from Medias Single
                    if ($field['name'] == 'medias_single') {
                        if (isset($value['mainimage']) && ! is_null($value['mainimage'])) {
                            $file = File::find($value['mainimage']);
                            $value = $file->pathString ?? '--';
                        } else {
                            $value = '--';
                        }
                    }
                }

                //Add extra field value
                array_push($baseItem, $value);
            }
        }

        return $baseItem;
    }

    /**
     * Table headings
     *
     * @return string[]
     */
    public function headings(): array
    {
        $baseFields = $this->report->getHeading();

        return $baseFields;
    }

    /**
     * Each Item
     */
    public function map($item): array
    {
        $baseItem = $this->report->getMap($item);

        return $baseItem;
    }

    /**
     * Handling Events
     */
    public function registerEvents(): array
    {
        return [

            //Event gets raised just after the sheet is created.
            BeforeSheet::class => function (BeforeSheet $event) {
                \Log::info('Requestable:: Exports|BeforeSheet: Init');
            },

            // Event gets raised at the end of the sheet process
            AfterSheet::class => function (AfterSheet $event) {
                \Log::info('Requestable:: Exports|AfterSheet: Exported');

                $event->getSheet()->getDelegate()->getStyle(1)->getFont()->setBold(true);

                //Send pusher notification
                $this->inotification->to(['broadcast' => $this->params->user->id])->push([
                    'title' => 'New report',
                    'message' => 'Your report is ready!',
                    'link' => url(''),
                    'isAction' => true,
                    'frontEvent' => [
                        'name' => 'isite.export.ready',
                        'data' => $this->exportParams,
                    ],
                    'setting' => ['saveInDatabase' => 1],
                ]);
            },

        ];
    }
}
