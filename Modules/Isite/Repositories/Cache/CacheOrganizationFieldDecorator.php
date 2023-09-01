<?php

namespace Modules\Isite\Repositories\Cache;

use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;
use Modules\Isite\Repositories\OrganizationFieldRepository;

class CacheOrganizationFieldDecorator extends BaseCacheCrudDecorator implements OrganizationFieldRepository
{
    public function __construct(OrganizationFieldRepository $organizationfield)
    {
        parent::__construct();
        $this->entityName = 'isite.organizationfields';
        $this->repository = $organizationfield;
    }
}
