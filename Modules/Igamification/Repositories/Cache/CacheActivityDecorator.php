<?php

namespace Modules\Igamification\Repositories\Cache;

use Modules\Igamification\Repositories\ActivityRepository;
use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;

class CacheActivityDecorator extends BaseCacheCrudDecorator implements ActivityRepository
{
    public function __construct(ActivityRepository $activity)
    {
        parent::__construct();
        $this->entityName = 'igamification.activities';
        $this->repository = $activity;
    }
}
