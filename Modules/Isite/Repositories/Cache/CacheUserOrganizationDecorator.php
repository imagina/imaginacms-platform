<?php

namespace Modules\Isite\Repositories\Cache;

use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;
use Modules\Isite\Repositories\UserOrganizationRepository;

class CacheUserOrganizationDecorator extends BaseCacheCrudDecorator implements UserOrganizationRepository
{
    public function __construct(UserOrganizationRepository $userorganization)
    {
        parent::__construct();
        $this->entityName = 'isite.userorganizations';
        $this->repository = $userorganization;
    }
}
