<?php

namespace Modules\Icheckin\Repositories\Cache;

use Modules\Icheckin\Repositories\JobRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheJobDecorator extends BaseCacheDecorator implements JobRepository
{
    public function __construct(JobRepository $job)
    {
        parent::__construct();
        $this->entityName = 'icheckin.jobs';
        $this->repository = $job;
    }
}
