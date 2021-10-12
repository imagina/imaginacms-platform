<?php

namespace Modules\Isite\Repositories\Cache;

use Modules\Isite\Repositories\OrganizationRepository;
use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;

class CacheOrganizationDecorator extends BaseCacheCrudDecorator implements OrganizationRepository
{
    public function __construct(OrganizationRepository $organization)
    {
        parent::__construct();
        $this->entityName = 'isite.organizations';
        $this->repository = $organization;
    }
}
