<?php

namespace Modules\Iplan\Repositories\Cache;

use Modules\Core\Repositories\Cache\BaseCacheDecorator;
use Modules\Iplan\Repositories\SubscriptionRepository;

class CacheSubscriptionDecorator extends BaseCacheDecorator implements SubscriptionRepository
{
    public function __construct(SubscriptionRepository $subscription)
    {
        parent::__construct();
        $this->entityName = 'iplan.subscriptions';
        $this->repository = $subscription;
    }
}
