<?php

namespace Modules\Qreable\Repositories\Cache;

use Modules\Qreable\Repositories\QredRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheQredDecorator extends BaseCacheDecorator implements QredRepository
{
    public function __construct(QredRepository $qred)
    {
        parent::__construct();
        $this->entityName = 'qreable.qreds';
        $this->repository = $qred;
    }
}
