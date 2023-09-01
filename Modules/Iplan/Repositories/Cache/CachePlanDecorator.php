<?php

namespace Modules\Iplan\Repositories\Cache;

use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;
use Modules\Iplan\Repositories\PlanRepository;

class CachePlanDecorator extends BaseCacheCrudDecorator implements PlanRepository
{
    public function __construct(PlanRepository $plan)
    {
        parent::__construct();
        $this->entityName = 'iplan.plans';
        $this->repository = $plan;
    }
}
