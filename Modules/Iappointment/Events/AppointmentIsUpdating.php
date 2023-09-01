<?php

namespace Modules\Iappointment\Events;

class AppointmentIsUpdating
{
    public $model;

    public $data;

    /**
     * Create a new event instance.
     */
    public function __construct($data, $model)
    {
        $this->data = $data;
        $this->model = $model;
    }
}
