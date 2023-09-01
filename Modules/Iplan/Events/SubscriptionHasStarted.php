<?php

namespace Modules\Iplan\Events;

class SubscriptionHasStarted
{
    public $model;

    public function __construct($model)
    {
        $this->model = $model;
    }
}
