<?php

namespace Modules\Igamification\Events;

class ActivityIsIncompleted
{
    
    public $params;

    public function __construct($params = null)
    {
        $this->params = $params;
    }

}