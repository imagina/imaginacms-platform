<?php

namespace Modules\Isite\Repositories\Cache;

use Modules\Isite\Repositories\UserOrganizationRepository;
use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;

class CacheUserOrganizationDecorator extends BaseCacheCrudDecorator implements UserOrganizationRepository
{
    public function __construct(UserOrganizationRepository $userorganization)
    {
        parent::__construct();
        $this->entityName = 'isite.userorganizations';
        $this->repository = $userorganization;
    }
}
