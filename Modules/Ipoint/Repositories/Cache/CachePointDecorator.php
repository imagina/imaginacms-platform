<?php

namespace Modules\Ipoint\Repositories\Cache;

use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;
use Modules\Ipoint\Repositories\PointRepository;

class CachePointDecorator extends BaseCacheCrudDecorator implements PointRepository
{
    public function __construct(PointRepository $point)
    {
        parent::__construct();
        $this->entityName = 'ipoint.points';
        $this->repository = $point;
    }

    public function calculate($parameters, $conf)
    {
        return $this->remember(function () use ($parameters, $conf) {
            return $this->repository->calculate($parameters, $conf);
        });
    }
}
