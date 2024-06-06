<?php

namespace Modules\Iprofile\Repositories\Cache;

use Modules\Iprofile\Repositories\RoleApiRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheRoleApiDecorator extends BaseCacheDecorator implements RoleApiRepository
{
    public function __construct(RoleApiRepository $roleapi)
    {
        parent::__construct();
        $this->entityName = 'iprofile.roleapis';
        $this->repository = $roleapi;
    }
}
