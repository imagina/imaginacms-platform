<?php

namespace Modules\Isite\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use Modules\Iprofile\Events\UserCreatedEvent;
use Modules\Isite\Events\Handlers\CreateOrganizationByRole;
use Modules\Isite\Events\Handlers\CreateOrganizationBySuscription;
use Modules\Isite\Events\Handlers\SetMaintenanceMode;
use Modules\Isite\Events\OrganizationWasUpdated;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        /*
        UserCreatedEvent::class => [
            CreateOrganizationByRole::class
        ],
        */
        OrganizationWasUpdated::class => [
            SetMaintenanceMode::class,
        ],

    ];

    public function register(): void
    {
        if (is_module_enabled('Iplan')) {
            Event::listen(
                'Modules\\Iplan\\Events\\SubscriptionHasStarted',
                [CreateOrganizationBySuscription::class, 'handle']
            );
        }
    }
}
