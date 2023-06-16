<?php

namespace Modules\Icommercebraintree\Repositories\Cache;

use Modules\Core\Repositories\Cache\BaseCacheDecorator;
use Modules\Icommercebraintree\Repositories\IcommerceBraintreeRepository;

class CacheIcommerceBraintreeDecorator extends BaseCacheDecorator implements IcommerceBraintreeRepository
{
    public function __construct(IcommerceBraintreeRepository $icommercebraintree)
    {
        parent::__construct();
        $this->entityName = 'icommercebraintree.icommercebraintrees';
        $this->repository = $icommercebraintree;
    }
}
