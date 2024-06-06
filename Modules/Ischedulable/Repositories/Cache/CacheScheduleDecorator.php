<?php

namespace Modules\Ischedulable\Repositories\Cache;

use Modules\Ischedulable\Repositories\ScheduleRepository;
use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;

class CacheScheduleDecorator extends BaseCacheCrudDecorator implements ScheduleRepository
{
    public function __construct(ScheduleRepository $schedule)
    {
        parent::__construct();
        $this->entityName = 'ischedulable.schedules';
        $this->repository = $schedule;
    }
}
