<?php

namespace Modules\Iprofile\Repositories\Cache;

use Modules\Iprofile\Repositories\UserDepartmentRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheUserDepartmentDecorator extends BaseCacheDecorator implements UserDepartmentRepository
{
    public function __construct(UserDepartmentRepository $userdepartment)
    {
        parent::__construct();
        $this->entityName = 'iprofile.userdepartments';
        $this->repository = $userdepartment;
    }
}
