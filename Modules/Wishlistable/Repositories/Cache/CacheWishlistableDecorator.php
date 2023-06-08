<?php

namespace Modules\Wishlistable\Repositories\Cache;

use Modules\Wishlistable\Repositories\WishlistableRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheWishlistableDecorator extends BaseCacheDecorator implements WishlistableRepository
{
    public function __construct(WishlistableRepository $wishlistable)
    {
        parent::__construct();
        $this->entityName = 'wishlistable.wishlistables';
        $this->repository = $wishlistable;
    }
}
