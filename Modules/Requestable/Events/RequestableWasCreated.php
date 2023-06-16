<?php

namespace Modules\Requestable\Events;

class RequestableWasCreated
{
    public $requestable;

    public function __construct($requestable)
    {
        $this->requestable = $requestable;
    }
}
