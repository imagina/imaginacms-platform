<?php

namespace Modules\Iad\Repositories\Cache;

use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;
use Modules\Iad\Repositories\UpLogRepository;

class CacheUpLogDecorator extends BaseCacheCrudDecorator implements UpLogRepository
{
    public function __construct(UpLogRepository $uplog)
    {
        parent::__construct();
        $this->entityName = 'iad.uplogs';
        $this->repository = $uplog;
    }
}
