<?php

namespace Modules\Icommercefreeshipping\Repositories\Cache;

use Modules\Icommercefreeshipping\Repositories\IcommerceFreeshippingRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheIcommerceFreeshippingDecorator extends BaseCacheDecorator implements IcommerceFreeshippingRepository
{
    public function __construct(IcommerceFreeshippingRepository $icommercefreeshipping)
    {
        parent::__construct();
        $this->entityName = 'icommercefreeshipping.icommercefreeshippings';
        $this->repository = $icommercefreeshipping;
    }

     /**
     * List or resources
     *
     * @return mixed
     */
    public function calculate($parameters,$conf)
    {
        return $this->remember(function () use ($parameters,$conf) {
            return $this->repository->calculate($parameters,$conf);
        });
    }
    
}
