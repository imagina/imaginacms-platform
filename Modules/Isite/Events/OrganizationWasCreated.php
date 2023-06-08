<?php


namespace Modules\Isite\Events;


class OrganizationWasCreated
{
    public $organization;
   

    public function __construct($organization)
    {
        $this->organization = $organization;
    }

}
