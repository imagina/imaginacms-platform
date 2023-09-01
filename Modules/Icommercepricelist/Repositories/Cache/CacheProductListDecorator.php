<?php

namespace Modules\Icommercepricelist\Repositories\Cache;

use Modules\Core\Repositories\Cache\BaseCacheDecorator;
use Modules\Icommercepricelist\Repositories\ProductListRepository;

class CacheProductListDecorator extends BaseCacheDecorator implements ProductListRepository
{
    public function __construct(ProductListRepository $productlist)
    {
        parent::__construct();
        $this->entityName = 'icommercepricelist.productlists';
        $this->repository = $productlist;
    }
}
