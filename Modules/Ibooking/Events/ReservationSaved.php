<?php

namespace Modules\Ibooking\Events;

use Modules\Ibooking\Entities\Reservation;

class ReservationSaved
{
    
     /**
     * The order instance.
     *
     * @var \App\Models\Order
     */
    public $reservation;

    /**
     * Create a new event instance.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function __construct(Reservation $reservation)
    {
        $this->reservation = $reservation;
    }

}