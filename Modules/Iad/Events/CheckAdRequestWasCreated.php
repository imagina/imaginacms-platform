<?php

namespace Modules\Iad\Events;

class CheckAdRequestWasCreated
{
    public $request;

    public $action;

    public function __construct($request)
    {
        $this->action = 'created';
        $this->request = $request;
    }
}
