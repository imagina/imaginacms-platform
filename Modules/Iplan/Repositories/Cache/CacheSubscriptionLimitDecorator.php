<?php

namespace Modules\Iplan\Repositories\Cache;

use Modules\Iplan\Repositories\SubscriptionLimitRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheSubscriptionLimitDecorator extends BaseCacheDecorator implements SubscriptionLimitRepository
{
    public function __construct(SubscriptionLimitRepository $subscriptionlimit)
    {
        parent::__construct();
        $this->entityName = 'iplan.subscriptionlimits';
        $this->repository = $subscriptionlimit;
    }
}
