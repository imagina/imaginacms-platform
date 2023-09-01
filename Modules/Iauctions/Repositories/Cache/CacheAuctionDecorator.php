<?php

namespace Modules\Iauctions\Repositories\Cache;

use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;
use Modules\Iauctions\Repositories\AuctionRepository;

class CacheAuctionDecorator extends BaseCacheCrudDecorator implements AuctionRepository
{
    public function __construct(AuctionRepository $auction)
    {
        parent::__construct();
        $this->entityName = 'iauctions.auctions';
        $this->repository = $auction;
    }
}
