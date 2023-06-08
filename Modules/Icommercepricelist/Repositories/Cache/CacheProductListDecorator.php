<?php

namespace Modules\Icommercepricelist\Repositories\Cache;

use Modules\Icommercepricelist\Repositories\ProductListRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheProductListDecorator extends BaseCacheDecorator implements ProductListRepository
{
    public function __construct(ProductListRepository $productlist)
    {
        parent::__construct();
        $this->entityName = 'icommercepricelist.productlists';
        $this->repository = $productlist;
    }
}
