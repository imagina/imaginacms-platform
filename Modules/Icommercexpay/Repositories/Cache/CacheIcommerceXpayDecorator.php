<?php

namespace Modules\Icommercexpay\Repositories\Cache;

use Modules\Core\Repositories\Cache\BaseCacheDecorator;
use Modules\Icommercexpay\Repositories\IcommerceXpayRepository;

class CacheIcommerceXpayDecorator extends BaseCacheDecorator implements IcommerceXpayRepository
{
    public function __construct(IcommerceXpayRepository $icommercexpay)
    {
        parent::__construct();
        $this->entityName = 'icommercexpay.icommercexpays';
        $this->repository = $icommercexpay;
    }
}
