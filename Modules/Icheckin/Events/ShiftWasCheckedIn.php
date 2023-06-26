<?php

namespace Modules\Icheckin\Events;

use Modules\Icheckin\Entities\Shift;

class ShiftWasCheckedIn
{
    public $model;

    /**
     * Create a new event instance.
     */
    public function __construct(Shift $model)
    {
        $this->model = $model;
    }
}
