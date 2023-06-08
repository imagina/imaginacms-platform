<?php

namespace Modules\Requestable\Repositories\Cache;

use Modules\Requestable\Repositories\StatusHistoryRepository;
use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;

class CacheStatusHistoryDecorator extends BaseCacheCrudDecorator implements StatusHistoryRepository
{
    public function __construct(StatusHistoryRepository $statushistory)
    {
        parent::__construct();
        $this->entityName = 'requestable.statushistories';
        $this->repository = $statushistory;
    }
}
