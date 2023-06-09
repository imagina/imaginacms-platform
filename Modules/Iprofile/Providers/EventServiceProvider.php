<?php

namespace Modules\Iprofile\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
//Events
use Modules\Iprofile\Events\Handlers\CreateQrByDepartments;
use Modules\Iprofile\Events\Handlers\CreateUserPasswordHistory;
use Modules\Iprofile\Events\Handlers\NotificationUserCreatedToAdmins;
//Handlers
use Modules\Iprofile\Events\UserCreatedEvent;
use Modules\Iprofile\Events\UserUpdatedEvent;
use Modules\User\Events\UserWasCreated;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        UserCreatedEvent::class => [
            CreateUserPasswordHistory::class,
            CreateQrByDepartments::class,
            NotificationUserCreatedToAdmins::class,
        ],
        UserUpdatedEvent::class => [
            CreateUserPasswordHistory::class,
            CreateQrByDepartments::class,
        ],
        UserWasCreated::class => [
            NotificationUserCreatedToAdmins::class,
        ],
    ];
}
