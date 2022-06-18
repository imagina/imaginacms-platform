<?php

namespace Modules\Iprofile\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

//Events
use Modules\Iprofile\Events\UserCreatedEvent;
use Modules\Iprofile\Events\UserUpdatedEvent;

//Handlers
use Modules\Iprofile\Events\Handlers\CreateUserPasswordHistory;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        UserCreatedEvent::class => [
            CreateUserPasswordHistory::class
        ],
        UserUpdatedEvent::class => [
            CreateUserPasswordHistory::class
        ]
    ];
}
