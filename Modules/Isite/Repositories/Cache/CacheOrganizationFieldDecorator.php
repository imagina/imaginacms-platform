<?php

namespace Modules\Isite\Repositories\Cache;

use Modules\Isite\Repositories\OrganizationFieldRepository;
use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;

class CacheOrganizationFieldDecorator extends BaseCacheCrudDecorator implements OrganizationFieldRepository
{
    public function __construct(OrganizationFieldRepository $organizationfield)
    {
        parent::__construct();
        $this->entityName = 'isite.organizationfields';
        $this->repository = $organizationfield;
    }
}
