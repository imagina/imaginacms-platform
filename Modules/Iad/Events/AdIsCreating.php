<?php

namespace Modules\Iad\Events;

use Modules\Iad\Entities\Ad;

class AdIsCreating
{
    public $model;

    public function __construct($model)
    {
        $this->model = new Ad($model);
    }
}
