<?php

namespace Modules\Icommerceepayco\Repositories\Cache;

use Modules\Core\Repositories\Cache\BaseCacheDecorator;
use Modules\Icommerceepayco\Repositories\IcommerceEpaycoRepository;

class CacheIcommerceEpaycoDecorator extends BaseCacheDecorator implements IcommerceEpaycoRepository
{
    public function __construct(IcommerceEpaycoRepository $icommerceepayco)
    {
        parent::__construct();
        $this->entityName = 'icommerceepayco.icommerceepaycos';
        $this->repository = $icommerceepayco;
    }

    public function calculate($parameters, $conf)
    {
        return $this->remember(function () use ($parameters, $conf) {
            return $this->repository->calculate($parameters, $conf);
        });
    }
}
