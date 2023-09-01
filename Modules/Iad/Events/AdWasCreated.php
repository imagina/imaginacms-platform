<?php

namespace Modules\Iad\Events;

class AdWasCreated
{
    public $model;

    public function __construct($model)
    {
        $this->model = $model;
    }
}
