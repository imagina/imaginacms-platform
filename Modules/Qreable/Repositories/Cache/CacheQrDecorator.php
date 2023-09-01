<?php

namespace Modules\Qreable\Repositories\Cache;

use Modules\Core\Repositories\Cache\BaseCacheDecorator;
use Modules\Qreable\Repositories\QrRepository;

class CacheQrDecorator extends BaseCacheDecorator implements QrRepository
{
    public function __construct(QrRepository $qr)
    {
        parent::__construct();
        $this->entityName = 'qreable.locations';
        $this->repository = $qr;
    }
}
