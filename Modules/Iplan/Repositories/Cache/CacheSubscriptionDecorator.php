<?php

namespace Modules\Iplan\Repositories\Cache;

use Modules\Iplan\Repositories\SubscriptionRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheSubscriptionDecorator extends BaseCacheDecorator implements SubscriptionRepository
{
    public function __construct(SubscriptionRepository $subscription)
    {
        parent::__construct();
        $this->entityName = 'iplan.subscriptions';
        $this->repository = $subscription;
    }
}
