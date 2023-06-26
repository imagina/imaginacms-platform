<?php

namespace Modules\Isite\Exports;

use Illuminate\Support\Collection;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithEvents;
//Events
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Events\BeforeWriting;

//Extra

class RepositoryExport implements FromQuery, WithEvents, ShouldQueue, WithHeadings
{
    use Exportable;

    private $params;

    private $exportParams;

    private $inotification;

    public function __construct($params, $exportParams)
    {
        $this->params = $params;
        $this->exportParams = $exportParams;
        $this->inotification = app('Modules\Notification\Services\Inotification');
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function query(): Collection
    {
        //Init Repo
        $repository = app("Modules\\{$this->exportParams->moduleName}\\Repositories\\{$this->exportParams->repositoryName}");
        //Set fields and extra params
        $this->params->fields = $this->exportParams->fields;
        $this->params->returnAsQuery = true;
        //Get query
        $query = $repository->getItemsBy($this->params);
        //Response
        return $query;
    }

    /**
     * Table headings
     *
     * @return string[]
     */
    public function headings(): array
    {
        return $this->exportParams->headings;
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
