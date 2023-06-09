<?php

namespace Modules\Icheckin\Repositories\Cache;

use Modules\Core\Repositories\Cache\BaseCacheDecorator;
use Modules\Icheckin\Repositories\JobRepository;

class CacheJobDecorator extends BaseCacheDecorator implements JobRepository
{
    public function __construct(JobRepository $job)
    {
        parent::__construct();
        $this->entityName = 'icheckin.jobs';
        $this->repository = $job;
    }
}
