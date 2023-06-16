<?php

namespace Modules\Iforms\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\Iforms\Events\Handlers\HandleFormeable;
use Modules\Iforms\Events\Handlers\SendEmail;
use Modules\Iforms\Events\LeadWasCreated;
use Modules\Iforms\Events\SyncFormeable;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        LeadWasCreated::class => [
            SendEmail::class,
        ],
        SyncFormeable::class => [
            HandleFormeable::class,
        ],
    ];
}
