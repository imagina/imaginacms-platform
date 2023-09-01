<?php

namespace Modules\Ibooking\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
//Handlers
use Modules\Ibooking\Events\Handlers\ProcessReservationOrder;
use Modules\Ibooking\Events\Handlers\SendReservation;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
    ];

    public function register(): void
    {
        // Order Was Processed
        if (is_module_enabled('Icommerce')) {
            //Listen order processed
            Event::listen(
                'Modules\\Icommerce\\Events\\OrderWasProcessed',
                [ProcessReservationOrder::class, 'handle']
            );
        }

        // Reservation Was Created
        Event::listen(
            'Modules\\Ibooking\\Events\\ReservationWasCreated',
            [SendReservation::class, 'handle']
        );
    }
}
