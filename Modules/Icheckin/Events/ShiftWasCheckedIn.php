<?php

namespace Modules\Icheckin\Events;

use Modules\Icheckin\Entities\Shift;

class ShiftWasCheckedIn
{
    public $model;

    /**
     * Create a new event instance.
     *
     * @param Shift $model
     */
    public function __construct($model)
    {
        $this->model = $model;
    }
}
