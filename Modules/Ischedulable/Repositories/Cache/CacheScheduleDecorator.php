<?php

namespace Modules\Ischedulable\Repositories\Cache;

use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;
use Modules\Ischedulable\Repositories\ScheduleRepository;

class CacheScheduleDecorator extends BaseCacheCrudDecorator implements ScheduleRepository
{
    public function __construct(ScheduleRepository $schedule)
    {
        parent::__construct();
        $this->entityName = 'ischedulable.schedules';
        $this->repository = $schedule;
    }
}
