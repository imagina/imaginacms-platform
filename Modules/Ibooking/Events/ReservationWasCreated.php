<?php

namespace Modules\Ibooking\Events;

use Modules\Ibooking\Entities\Reservation;

class ReservationWasCreated
{
    
    
    public $reservation;
    public $params;

    public function __construct(Reservation $reservation,$params = null)
    {
        $this->reservation = $reservation;
        $this->params = $params;
    }

}