<?php

namespace Modules\Ischedulable\Repositories\Cache;

use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;
use Modules\Ischedulable\Repositories\DayRepository;

class CacheDayDecorator extends BaseCacheCrudDecorator implements DayRepository
{
    public function __construct(DayRepository $day)
    {
        parent::__construct();
        $this->entityName = 'ischedulable.days';
        $this->repository = $day;
    }
}
