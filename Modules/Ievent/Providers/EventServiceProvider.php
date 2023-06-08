<?php

namespace Modules\Ievent\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\Ievent\Events\EventWasCreated;
use Modules\Ievent\Events\Handlers\SaveFirstAttendant;


class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        EventWasCreated::class => [
           SaveFirstAttendant::class,
        ],
   

    ];
}