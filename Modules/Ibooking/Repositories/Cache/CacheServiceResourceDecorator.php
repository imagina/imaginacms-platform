<?php

namespace Modules\Ibooking\Repositories\Cache;

use Modules\Core\Repositories\Cache\BaseCacheDecorator;
use Modules\Ibooking\Repositories\ServiceResourceRepository;

class CacheServiceResourceDecorator extends BaseCacheDecorator implements ServiceResourceRepository
{
    public function __construct(ServiceResourceRepository $serviceresource)
    {
        parent::__construct();
        $this->entityName = 'ibooking.serviceresources';
        $this->repository = $serviceresource;
    }
}
