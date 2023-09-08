<?php

namespace Modules\Isite\Repositories\Cache;

use Modules\Isite\Repositories\ReportQueueRepository;
use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;

class CacheReportQueueDecorator extends BaseCacheCrudDecorator implements ReportQueueRepository
{
    public function __construct(ReportQueueRepository $reportqueue)
    {
        parent::__construct();
        $this->entityName = 'isite.reportqueues';
        $this->repository = $reportqueue;
    }
}
