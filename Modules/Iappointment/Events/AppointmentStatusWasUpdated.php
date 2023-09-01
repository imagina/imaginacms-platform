<?php

namespace Modules\Iappointment\Events;

class AppointmentStatusWasUpdated
{
    public $model;

    public $data;

    /**
     * Create a new event instance.
     */
    public function __construct($model, $data)
    {
        $this->model = $model;
        $this->data = $data;
    }
}
