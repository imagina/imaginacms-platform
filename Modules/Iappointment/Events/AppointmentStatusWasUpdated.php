<?php

namespace Modules\Iappointment\Events;


use Modules\Iappointment\Entities\Appointment;

class AppointmentStatusWasUpdated
{
    public $model;
    public $data;

    /**
     * Create a new event instance.
     *
     * @param $model
     */
    public function __construct($model,$data)
    {
        $this->model = $model;
        $this->data = $data;
    }

}
