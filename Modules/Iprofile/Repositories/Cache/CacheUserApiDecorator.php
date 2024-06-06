<?php

namespace Modules\Iprofile\Repositories\Cache;

use Modules\Iprofile\Repositories\UserApiRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheUserApiDecorator extends BaseCacheDecorator implements UserApiRepository
{
    public function __construct(UserApiRepository $userapi)
    {
        parent::__construct();
        $this->entityName = 'iprofile.userapis';
        $this->repository = $userapi;
    }
}
