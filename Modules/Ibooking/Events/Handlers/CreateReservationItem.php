<?php

namespace Modules\Ibooking\Events\Handlers;

use Modules\Ibooking\Events\ReservationSaved;

class CreateReservationItem
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct($eventData)
    {
        dd('attributes on handler', $eventData->getAttributes());
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\OrderShipped  $event
     * @return void
     */
    public function handle(ReservationSaved $event): void
    {
        dd('AJDKSJDKJKAS', $event);
    }
}
