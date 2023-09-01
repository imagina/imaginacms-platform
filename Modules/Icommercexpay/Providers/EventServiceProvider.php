<?php

namespace Modules\Icommercexpay\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\Icommercexpay\Events\ResponseWasReceived;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        ResponseWasReceived::class => [
            //UpdateOrderStatus::class,
        ],

    ];
}
