<?php

namespace Modules\Iauctions\Exports;

use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
//Events
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;
//Entities
use Modules\Iauctions\Entities\Auction;
use Modules\Media\Entities\File;

//Extra

class BidsExport implements FromQuery, WithEvents, ShouldQueue, WithMapping, WithHeadings
{
    use Exportable;

    private $params;

    private $exportParams;

    private $inotification;

    private $bidRepository;

    private $auction = null;

    private $fieldsBid = null;

    public function __construct($params, $exportParams)
    {
    $this->userId = \Auth::id();//Set for ReportQueue
        $this->params = $params;
        $this->exportParams = $exportParams;
        $this->inotification = app('Modules\Notification\Services\Inotification');
        $this->bidRepository = app('Modules\Iauctions\Repositories\BidRepository');

        $this->getExtraFieldsToBid();
    }

    /*
    * Get items from repository
    */
    public function query()
    {
        $this->params->returnAsQuery = true;

        $order['field'] = 'id';
        $this->params->filter->order = (object) $order;

        return $this->bidRepository->getItemsBy($this->params);
    }

    /**
     * Get Auction from filter params
     *
     * @param params->filter - $filter->auctionId
     */
    public function getAuction()
    {
        $filter = $this->params->filter ?? null;
        if (! is_null($filter)) {
            if (isset($filter->auctionId)) {
                $this->auction = Auction::find($filter->auctionId);
            }
        }
    }

    /*
    * Get Fields from Auction-Category-Bidform
    * Init in construct class
    */
    public function getExtraFieldsToBid()
    {
        // Get Auction From Filter Params
        $this->getAuction();

        if (! is_null($this->auction) && ! is_null($this->auction->category) && ! is_null($this->auction->category->bidForm)) {
            $fieldsAll = $this->auction->category->bidForm->fields;
            $this->fieldsBid = $fieldsAll->map->only('name', 'label', 'type');
        }
    }

    /**
     * Table headings
     *
     * @return string[]
     */
    public function headings(): array
    {
        // Base Fields
        $baseFields = [
            'ID',
            trans('iauctions::auctions.single'),
            trans('iauctions::bids.table.provider'),
            trans('iauctions::bids.table.description'),
            //trans('iauctions::bids.table.status'),
            //trans('iauctions::bids.table.amount'),
            //trans('iauctions::bids.table.winner'),
            //trans('iauctions::bids.table.create at')
        ];

        //Extra fields BID
        if (! is_null($this->fieldsBid)) {
            foreach ($this->fieldsBid as $key => $field) {
                array_push($baseFields, rtrim(str_replace('*', '', $field['label'])));
            }
        }

        return $baseFields;
    }

    /*
    * Get fields and add to item
    */
    public function addFieldsBidToItem($item, $baseItem)
    {
        //Extra fields
        if (! is_null($this->fieldsBid)) {
            foreach ($this->fieldsBid as $key => $field) {
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

                    //Convert string to show in excel - not like empty
                    if ($value == 0) {
                        $value = (string) $value;
                    }
                }

                //Add extra field value
                array_push($baseItem, $value);
            }
        }

        return $baseItem;
    }

    /**
     * Each Item
     */
    public function map($item): array
    {
        // Base Item Fields
        $baseItem = [
            $item->id ?? null,
            $item->auction->title ?? null,
            $item->provider->present()->fullname ?? null,
            strip_tags($item->description) ?? null,
            //$item->statusName ?? null,
            //$item->amount ?? null,
            //$item->winner ? "SI" : "NO",
            //date("d-m-Y",strtotime($item->created_at)) ?? null
        ];

        //Extra Fields - Bid
        $baseItem = $this->addFieldsBidToItem($item, $baseItem);

        //if($item->id==6)
        //dd($baseItem);

        return $baseItem;
    }

    /**
     * Handling Events
     */
    public function registerEvents(): array
    {
        return [
      // Event gets raised at the start of the process.
      BeforeExport::class => function (BeforeExport $event) {
        $this->lockReport($this->exportParams->exportName);
      },
            // Event gets raised at the end of the sheet process

            AfterSheet::class => function (AfterSheet $event) {
        $this->unlockReport($this->exportParams->exportName);
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
