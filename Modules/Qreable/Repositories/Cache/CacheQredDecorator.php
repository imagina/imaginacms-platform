<?php

namespace Modules\Qreable\Repositories\Cache;

use Modules\Core\Repositories\Cache\BaseCacheDecorator;
use Modules\Qreable\Repositories\QredRepository;

class CacheQredDecorator extends BaseCacheDecorator implements QredRepository
{
    public function __construct(QredRepository $qred)
    {
        parent::__construct();
        $this->entityName = 'qreable.qreds';
        $this->repository = $qred;
    }
}
