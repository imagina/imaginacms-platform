<?php

namespace Modules\Iforms\Exports;

use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithEvents;
//Events
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Events\BeforeWriting;
//Extra
use Modules\Iforms\Entities\Form;

class LeadsExport implements WithEvents, WithMultipleSheets, ShouldQueue
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

    public function sheets(): array
    {
        //Get forms
        $forms = (isset($this->params->filter->formId) && $this->params->filter->formId) ?
          Form::where('id', $this->params->filter->formId)->with(['fields', 'translations'])->get() :
          Form::with(['fields', 'translations'])->get();

        //Add Sheets
        $sheets = [];
        foreach ($forms as $form) {
            $sheets[] = new LeadsPerFormExport($form, $this->params);
        }

        //Response
        return $sheets;
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
