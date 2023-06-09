<?php

namespace Modules\Iplan\Events;

class PlanWasCreated
{
    public $model;

    public $data;

    public function __construct($model, $data)
    {
        $this->model = $model;
        $this->data = $data;
    }
}
