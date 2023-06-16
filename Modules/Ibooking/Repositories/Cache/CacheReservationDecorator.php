<?php

namespace Modules\Ibooking\Repositories\Cache;

use Modules\Ibooking\Repositories\ReservationRepository;

class CacheReservationDecorator extends BaseCacheCrudDecorators implements ReservationRepository
{
    public function __construct(ReservationRepository $reservation)
    {
        parent::__construct();
        $this->entityName = 'ibooking.reservations';
        $this->repository = $reservation;
    }
}
