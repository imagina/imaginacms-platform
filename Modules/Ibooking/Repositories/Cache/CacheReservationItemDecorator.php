<?php

namespace Modules\Ibooking\Repositories\Cache;

use Modules\Ibooking\Repositories\ReservationItemRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheReservationItemDecorator extends BaseCacheDecorator implements ReservationItemRepository
{
    public function __construct(ReservationItemRepository $reservationitem)
    {
        parent::__construct();
        $this->entityName = 'ibooking.reservationitems';
        $this->repository = $reservationitem;
    }
}
