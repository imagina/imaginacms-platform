<?php

namespace Modules\Iplan\Repositories\Cache;

use Modules\Core\Repositories\Cache\BaseCacheDecorator;
use Modules\Iplan\Repositories\UserLimitRepository;

class CacheUserLimitDecorator extends BaseCacheDecorator implements UserLimitRepository
{
    public function __construct(UserLimitRepository $userlimit)
    {
        parent::__construct();
        $this->entityName = 'iplan.userlimits';
        $this->repository = $userlimit;
    }
}
