<?php

namespace Modules\Iappointment\Events;

use Modules\Iappointment\Entities\Appointment;

class AppointmentIsCreating
{
    public $model;

    /**
     * Create a new event instance.
     */
    public function __construct($model)
    {
        $this->model = new Appointment($model);
    }
}
