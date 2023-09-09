<?php

namespace Modules\Iforms\Exports;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithTitle;

//Events
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\BeforeWriting;
use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithMapping;

//Extra
use Modules\Iforms\Repositories\LeadRepository;
use Modules\Notification\Services\Inotification;
use Modules\Iforms\Entities\Form;

use Modules\Isite\Traits\ReportQueueTrait;

class LeadsPerFormExport implements FromQuery, WithHeadings, WithMapping, ShouldQueue, WithEvents
{
  use ReportQueueTrait;

    private $params;

    private $exportParams;

    private $leadRepository;

    private $inotification;

    public function __construct($params, $exportParams)
    {
        $this->exportParams = $exportParams;
        $this->params = $params;
        $this->leadRepository = app('Modules\Iforms\Repositories\LeadRepository');
        $this->inotification = app('Modules\Notification\Services\Inotification');
    }

    public function query(): Collection
    {
        //Get query
        $this->params->returnAsQuery = true;

        return $this->leadRepository->getItemsBy($this->params);
    }

    /*
    /**
     * Table headings
     *
     * @return string[]
     */
    public function headings(): array
    {
        //Get form data
        $form = Form::where('id', $this->params->filter->formId)->with(['fields'])->first();

        //Set fields
        return array_merge(
            $form->fields->pluck('label')->toArray(),
            ['Fecha de Creación', 'Fecha Ultima Actualización']
        );
    }

    /**
     * @var Invoice
     */
    public function map($lead): array
    {
        $values = (array) $lead->values;

        return array_merge(array_values($values), [$lead->created_at, $lead->updated_at]);
    }

    /**
     * //Handling Events
     */
    public function registerEvents(): array
    {
        return [
            // Event gets raised at the start of the process.
            BeforeExport::class => function (BeforeExport $event) {
            },
            // Event gets raised before the download/store starts.
            BeforeWriting::class => function (BeforeWriting $event) {
            },
            // Event gets raised just after the sheet is created.
            BeforeSheet::class => function (BeforeSheet $event) {
            },
            // Event gets raised at the end of the sheet process
            AfterSheet::class => function (AfterSheet $event) {
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
