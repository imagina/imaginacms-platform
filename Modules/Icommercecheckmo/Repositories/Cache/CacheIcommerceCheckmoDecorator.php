<?php

namespace Modules\Icommercecheckmo\Repositories\Cache;

use Modules\Icommercecheckmo\Repositories\IcommerceCheckmoRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheIcommerceCheckmoDecorator extends BaseCacheDecorator implements IcommerceCheckmoRepository
{
    public function __construct(IcommerceCheckmoRepository $icommercecheckmo)
    {
        parent::__construct();
        $this->entityName = 'icommercecheckmo.icommercecheckmos';
        $this->repository = $icommercecheckmo;
    }
}
