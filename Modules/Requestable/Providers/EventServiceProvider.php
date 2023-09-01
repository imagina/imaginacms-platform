<?php

namespace Modules\Requestable\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
//Events
use Modules\Iforms\Events\LeadWasCreated;
use Modules\Requestable\Events\Handlers\CheckStatusRequestable;
//Handlers
use Modules\Requestable\Events\Handlers\CreateRequestableByLeadData;
use Modules\Requestable\Events\RequestableWasCreated;
use Modules\Requestable\Events\RequestableWasUpdated;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [

        RequestableWasCreated::class => [
            CheckStatusRequestable::class,
        ],
        RequestableWasUpdated::class => [
            CheckStatusRequestable::class,
        ],
        LeadWasCreated::class => [
            CreateRequestableByLeadData::class,
        ],

    ];
}
