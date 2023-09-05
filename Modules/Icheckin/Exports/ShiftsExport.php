<?php

namespace Modules\Icheckin\Exports;

use Illuminate\Support\Collection;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
//Events
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Events\BeforeWriting;
//Extra
use Modules\Icheckin\Repositories\ShiftRepository;
use Modules\Icheckin\Transformers\ShiftTransformer;

class ShiftsExport implements FromCollection, WithEvents, ShouldQueue, WithMapping, WithHeadings
{
    use Exportable;

    private $params;

    private $exportParams;

    private $inotification;

    private $service;

    public function __construct($params, $exportParams, ShiftRepository $service)
    {
    $this->userId = \Auth::id();//Set for ReportQueue
        $this->params = $params;
        $this->exportParams = $exportParams;
        $this->inotification = app('Modules\Notification\Services\Inotification');
        $this->service = $service;
    }

    public function collection(): Collection
    {
        //Init Repo
        //$this->params->returnAsQuery = true;
        $shifts = $this->service->getItemsBy($this->params);
        $shiftsToTransForm = ShiftTransformer::collection($shifts);

        //Response
        return collect(json_decode(json_encode($shiftsToTransForm)));
    }

    /**
     * Table headings
     *
     * @return string[]
     */
    public function headings(): array
    {
        return [
            'Registrado por',
            'Tiempo (h:m:s)',
            'Registrado a las',
            'Cerrado a las',
            'Cerrado por',
            'Comments',
            'Ubicación inicial',
            'Ubicación final',
        ];
    }

    /**
     * @var Invoice
     */
    public function map($lead): array
    {
        return [
            ($lead->checkinBy->fullName ?? ''),
            ($lead->diff->h ?? '').':'.($lead->diff->i ?? '').':'.($lead->diff->s ?? ''),
            ($lead->checkinAt ?? ''),
            ($lead->checkoutAt ?? ''),
            ($lead->checkoutBy->fullName ?? ''),
            ($lead->comment ?? ''),
            'Lat: '.($lead->geoLocation->checkin->latitude ?? '').' | Lng: '.($lead->geoLocation->checkin->longitude ?? ''),
            'Lat: '.($lead->geoLocation->checkout->latitude ?? '').' | Lng: '.($lead->geoLocation->checkout->longitude ?? ''),
        ];
    }

    /**
     * //Handling Events
     */
    public function registerEvents(): array
    {
        return [
            // Event gets raised at the start of the process.
            BeforeExport::class => function (BeforeExport $event) {
        $this->lockReport($this->exportParams->exportName);
            },
            // Event gets raised before the download/store starts.
            BeforeWriting::class => function (BeforeWriting $event) {
            },
            // Event gets raised just after the sheet is created.
            BeforeSheet::class => function (BeforeSheet $event) {
            },
            // Event gets raised at the end of the sheet process
            AfterSheet::class => function (AfterSheet $event) {
        $this->unlockReport($this->exportParams->exportName);
                //Send pusher notification
                $this->inotification->to(['broadcast' => $this->params->user->id])->push([
                    'title' => 'Nuevo Reporte',
                    'message' => 'Tu reporte de Turnos está listo!',
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
