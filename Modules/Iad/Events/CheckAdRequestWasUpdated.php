<?php

namespace Modules\Iad\Events;

class CheckAdRequestWasUpdated
{
    public $request;

    public $action;

    public function __construct($request)
    {
        $this->action = 'updated';
        $this->request = $request;
    }
}
