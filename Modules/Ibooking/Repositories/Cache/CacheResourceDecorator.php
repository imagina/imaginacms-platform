<?php

namespace Modules\Ibooking\Repositories\Cache;

use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;
use Modules\Ibooking\Repositories\ResourceRepository;

class CacheResourceDecorator extends BaseCacheCrudDecorator implements ResourceRepository
{
    public function __construct(ResourceRepository $resource)
    {
        parent::__construct();
        $this->entityName = 'ibooking.resources';
        $this->repository = $resource;
    }
}
