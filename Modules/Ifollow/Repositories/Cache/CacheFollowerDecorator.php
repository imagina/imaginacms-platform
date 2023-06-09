<?php

namespace Modules\Ifollow\Repositories\Cache;

use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;
use Modules\Ifollow\Repositories\FollowerRepository;

class CacheFollowerDecorator extends BaseCacheCrudDecorator implements FollowerRepository
{
    public function __construct(FollowerRepository $follower)
    {
        parent::__construct();
        $this->entityName = 'ifollow.followers';
        $this->repository = $follower;
    }
}
