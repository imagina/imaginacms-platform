<?php

namespace Modules\Isite\Events;

class OrganizationWasCreated
{
    public $organization;
    public $user;

    public function __construct($organization,$user = null)
    {
        $this->organization = $organization;
        $this->user = $user;
    }
}
