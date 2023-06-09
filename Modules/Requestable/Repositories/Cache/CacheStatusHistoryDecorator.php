<?php

namespace Modules\Requestable\Repositories\Cache;

use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;
use Modules\Requestable\Repositories\StatusHistoryRepository;

class CacheStatusHistoryDecorator extends BaseCacheCrudDecorator implements StatusHistoryRepository
{
    public function __construct(StatusHistoryRepository $statushistory)
    {
        parent::__construct();
        $this->entityName = 'requestable.statushistories';
        $this->repository = $statushistory;
    }
}
