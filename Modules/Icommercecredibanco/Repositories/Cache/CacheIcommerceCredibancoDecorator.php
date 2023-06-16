<?php

namespace Modules\Icommercecredibanco\Repositories\Cache;

use Modules\Core\Repositories\Cache\BaseCacheDecorator;
use Modules\Icommercecredibanco\Repositories\IcommerceCredibancoRepository;

class CacheIcommerceCredibancoDecorator extends BaseCacheDecorator implements IcommerceCredibancoRepository
{
    public function __construct(IcommerceCredibancoRepository $icommercecredibanco)
    {
        parent::__construct();
        $this->entityName = 'icommercecredibanco.icommercecredibancos';
        $this->repository = $icommercecredibanco;
    }
}
