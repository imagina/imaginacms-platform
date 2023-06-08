<?php

namespace Modules\Requestable\Repositories\Cache;

use Modules\Requestable\Repositories\StatusRepository;
use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;

class CacheStatusDecorator extends BaseCacheCrudDecorator implements StatusRepository
{
    public function __construct(StatusRepository $status)
    {
        parent::__construct();
        $this->entityName = 'requestable.statuses';
        $this->repository = $status;
    }
}
