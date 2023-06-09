<?php

namespace Modules\Ibooking\Repositories\Cache;

use Modules\Core\Repositories\Cache\BaseCacheDecorator;
use Modules\Ibooking\Repositories\ReservationItemRepository;

class CacheReservationItemDecorator extends BaseCacheDecorator implements ReservationItemRepository
{
    public function __construct(ReservationItemRepository $reservationitem)
    {
        parent::__construct();
        $this->entityName = 'ibooking.reservationitems';
        $this->repository = $reservationitem;
    }
}
