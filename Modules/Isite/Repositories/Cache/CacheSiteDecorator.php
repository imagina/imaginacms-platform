<?php

namespace Modules\Isite\Repositories\Cache;

use Modules\Core\Repositories\Cache\BaseCacheDecorator;
use Modules\Isite\Repositories\SiteRepository;

class CacheSiteDecorator extends BaseCacheDecorator implements SiteRepository
{
    public function __construct(SiteRepository $site)
    {
        parent::__construct();
        $this->entityName = 'isite.sites';
        $this->repository = $site;
    }
}
