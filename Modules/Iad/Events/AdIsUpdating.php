<?php

namespace Modules\Iad\Events;

class AdIsUpdating
{
    public $data;

    public $model;

    public function __construct($data, $model)
    {
        $this->data = $data;
        $this->model = $model;
    }
}
