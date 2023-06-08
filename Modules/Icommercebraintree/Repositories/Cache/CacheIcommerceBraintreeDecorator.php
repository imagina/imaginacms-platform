<?php

namespace Modules\Icommercebraintree\Repositories\Cache;

use Modules\Icommercebraintree\Repositories\IcommerceBraintreeRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheIcommerceBraintreeDecorator extends BaseCacheDecorator implements IcommerceBraintreeRepository
{
    public function __construct(IcommerceBraintreeRepository $icommercebraintree)
    {
        parent::__construct();
        $this->entityName = 'icommercebraintree.icommercebraintrees';
        $this->repository = $icommercebraintree;
    }
}
