<?php

namespace Modules\Iad\Repositories\Cache;

use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;
use Modules\Iad\Repositories\UpRepository;

class CacheUpDecorator extends BaseCacheCrudDecorator implements UpRepository
{
    public function __construct(UpRepository $ups)
    {
        parent::__construct();
        $this->entityName = 'iad.ups';
        $this->repository = $ups;
    }
}
