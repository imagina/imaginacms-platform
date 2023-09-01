<?php

namespace Modules\Iappointment\Events\Handlers;

class AssignAppointmentFromCheckin
{
    public $appointmentService;

    public function __construct()
    {
        $this->appointmentService = app('Modules\Iappointment\Services\AppointmentService');
    }

    public function handle($event)
    {
        $shift = $event->model;
        if (empty($shift->checkout_at)) {
            \Log::info('Shift has been token by user '.$shift->checkinBy->present()->fullName.' . Checking Appointments...');
            $this->appointmentService->assign();
        }
    }
}
