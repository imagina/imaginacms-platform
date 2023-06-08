<?php

namespace Modules\Iplan\Repositories\Cache;

use Modules\Iplan\Repositories\UserLimitRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheUserLimitDecorator extends BaseCacheDecorator implements UserLimitRepository
{
    public function __construct(UserLimitRepository $userlimit)
    {
        parent::__construct();
        $this->entityName = 'iplan.userlimits';
        $this->repository = $userlimit;
    }
}
