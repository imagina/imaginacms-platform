<?php

namespace Modules\Igamification\Events;

class ActivityWasCompleted
{
    
    public $params;
    
    public function __construct($params = null)
    {
        $this->params = $params;
    }

}