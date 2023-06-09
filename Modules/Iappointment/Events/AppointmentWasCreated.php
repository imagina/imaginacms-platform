<?php

namespace Modules\Iappointment\Events;

class AppointmentWasCreated
{
    public $model;

    /**
     * Create a new event instance.
     *
     * @param $entity
     * @param  array  $data
     */
    public function __construct($model)
    {
        $this->model = $model;
    }
}
