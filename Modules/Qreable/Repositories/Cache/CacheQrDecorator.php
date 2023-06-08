<?php

namespace Modules\Qreable\Repositories\Cache;

use Modules\Qreable\Repositories\QrRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheQrDecorator extends BaseCacheDecorator implements QrRepository
{
    public function __construct(QrRepository $qr)
    {
        parent::__construct();
        $this->entityName = 'qreable.locations';
        $this->repository = $qr;
    }
}
