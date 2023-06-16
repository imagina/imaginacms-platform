<?php

namespace Modules\Icheckin\Repositories\Cache;

use Modules\Core\Repositories\Cache\BaseCacheDecorator;
use Modules\Icheckin\Repositories\ShiftRepository;

class CacheShiftDecorator extends BaseCacheDecorator implements ShiftRepository
{
    public function __construct(ShiftRepository $shift)
    {
        parent::__construct();
        $this->entityName = 'icheckin.shifts';
        $this->repository = $shift;
    }
}
