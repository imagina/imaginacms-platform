<?php

namespace Modules\Iauctions\Repositories\Cache;

use Modules\Iauctions\Repositories\AuctionRepository;
use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;

class CacheAuctionDecorator extends BaseCacheCrudDecorator implements AuctionRepository
{
    public function __construct(AuctionRepository $auction)
    {
        parent::__construct();
        $this->entityName = 'iauctions.auctions';
        $this->repository = $auction;
    }
}
