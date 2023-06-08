<?php

namespace Modules\Ibooking\Repositories\Cache;

use Modules\Ibooking\Repositories\ServiceResourceRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheServiceResourceDecorator extends BaseCacheDecorator implements ServiceResourceRepository
{
    public function __construct(ServiceResourceRepository $serviceresource)
    {
        parent::__construct();
        $this->entityName = 'ibooking.serviceresources';
        $this->repository = $serviceresource;
    }
}
