<?php

namespace Modules\Iplan\Repositories\Cache;

use Modules\Core\Repositories\Cache\BaseCacheDecorator;
use Modules\Iplan\Repositories\SubscriptionLimitRepository;

class CacheSubscriptionLimitDecorator extends BaseCacheDecorator implements SubscriptionLimitRepository
{
    public function __construct(SubscriptionLimitRepository $subscriptionlimit)
    {
        parent::__construct();
        $this->entityName = 'iplan.subscriptionlimits';
        $this->repository = $subscriptionlimit;
    }
}
