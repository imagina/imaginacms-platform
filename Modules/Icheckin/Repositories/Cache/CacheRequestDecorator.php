<?php

namespace Modules\Icheckin\Repositories\Cache;

use Modules\Icheckin\Repositories\RequestRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheRequestDecorator extends BaseCacheDecorator implements RequestRepository
{
    public function __construct(RequestRepository $request)
    {
        parent::__construct();
        $this->entityName = 'icheckin.requests';
        $this->repository = $request;
    }
}
