<?php

namespace Modules\Iplan\Events;

class SubscriptionHasFinished
{
    public $model;

    public function __construct($model)
    {
        $this->model = $model;
    }
}
