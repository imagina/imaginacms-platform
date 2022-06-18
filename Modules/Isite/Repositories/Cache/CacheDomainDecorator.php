<?php

namespace Modules\Isite\Repositories\Cache;

use Modules\Isite\Repositories\DomainRepository;
use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;

class CacheDomainDecorator extends BaseCacheCrudDecorator implements DomainRepository
{
    public function __construct(DomainRepository $domain)
    {
        parent::__construct();
        $this->entityName = 'isite.domains';
        $this->repository = $domain;
    }
}
