<?php


namespace Modules\Iad\Events;
use Modules\Iad\Entities\Ad;

class AdIsDeleting
{
    public $model;

    public function __construct($model)
    {
        $this->model = $model;
    }
}
