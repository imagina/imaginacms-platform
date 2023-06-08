<?php

namespace Modules\Iad\Repositories\Cache;

use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;
use Modules\Iad\Repositories\ScheduleRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheScheduleDecorator extends BaseCacheCrudDecorator implements ScheduleRepository
{
    public function __construct(ScheduleRepository $schedule)
    {
        parent::__construct();
        $this->entityName = 'iad.schedules';
        $this->repository = $schedule;
    }
}
