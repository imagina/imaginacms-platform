<?php

namespace Modules\Iad\Events;

class AdWasUpdated
{
    public $model;

    public function __construct($model)
    {
        $this->model = $model;
    }
}
