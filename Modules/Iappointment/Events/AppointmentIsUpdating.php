<?php

namespace Modules\Iappointment\Events;


use Modules\Iappointment\Entities\Appointment;

class AppointmentIsUpdating
{
    public $model;
    public $data;

    /**
     * Create a new event instance.
     *
     * @param $model
     * @param $data
     */
    public function __construct($data, $model)
    {
        $this->data = $data;
        $this->model = $model;
      
    }

}
