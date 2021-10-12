<?php

namespace Modules\Isite\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\Isite\Events\Handlers\CreateOrganizationByRole;
use Modules\Iprofile\Events\UserCreatedEvent;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
      UserCreatedEvent::class => [
            CreateOrganizationByRole::class
        ],
   
    ];
}
