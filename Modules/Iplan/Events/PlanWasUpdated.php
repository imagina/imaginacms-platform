<?php


namespace Modules\Iplan\Events;


class PlanWasUpdated
{
    public $model;
    public $data;
    public function __construct($model, $data)
    {
        $this->model = $model;
        $this->data = $data;
    }
}
