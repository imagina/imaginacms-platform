<?php

namespace Modules\Requestable\Events;

class RequestableWasUpdated
{
    
    public $requestable;
    
    
    public function __construct($requestable)
    {
        
        $this->requestable = $requestable;
        
    }

}