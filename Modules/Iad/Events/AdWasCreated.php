<?php


namespace Modules\Iad\Events;
use Modules\Iad\Entities\Ad;

class AdWasCreated
{
    public $model;

    public function __construct($model)
    {
        $this->model = $model;
    }
}
