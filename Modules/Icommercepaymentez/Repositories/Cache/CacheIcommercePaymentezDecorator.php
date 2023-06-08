<?php

namespace Modules\Icommercepaymentez\Repositories\Cache;

use Modules\Icommercepaymentez\Repositories\IcommercePaymentezRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheIcommercePaymentezDecorator extends BaseCacheDecorator implements IcommercePaymentezRepository
{
    public function __construct(IcommercePaymentezRepository $icommercepaymentez)
    {
        parent::__construct();
        $this->entityName = 'icommercepaymentez.icommercepaymentezs';
        $this->repository = $icommercepaymentez;
    }

    public function calculate($parameters,$conf)
    {
        return $this->remember(function () use ($parameters,$conf) {
            return $this->repository->calculate($parameters, $conf);
        });
    }
    
}
