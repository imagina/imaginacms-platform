<?php

namespace Modules\Ischedulable\Repositories\Cache;

use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;
use Modules\Ischedulable\Repositories\WorkTimeRepository;

class CacheWorkTimeDecorator extends BaseCacheCrudDecorator implements WorkTimeRepository
{
    public function __construct(WorkTimeRepository $worktime)
    {
        parent::__construct();
        $this->entityName = 'ischedulable.worktimes';
        $this->repository = $worktime;
    }
}
