<?php

namespace Modules\Ibooking\Repositories\Cache;

use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;
use Modules\Ibooking\Repositories\ServiceRepository;

class CacheServiceDecorator extends BaseCacheCrudDecorator implements ServiceRepository
{
    public function __construct(ServiceRepository $service)
    {
        parent::__construct();
        $this->entityName = 'ibooking.services';
        $this->repository = $service;
    }
}
