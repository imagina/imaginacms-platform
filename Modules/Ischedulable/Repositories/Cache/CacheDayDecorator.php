<?php

namespace Modules\Ischedulable\Repositories\Cache;

use Modules\Ischedulable\Repositories\DayRepository;
use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;

class CacheDayDecorator extends BaseCacheCrudDecorator implements DayRepository
{
    public function __construct(DayRepository $day)
    {
        parent::__construct();
        $this->entityName = 'ischedulable.days';
        $this->repository = $day;
    }
}
