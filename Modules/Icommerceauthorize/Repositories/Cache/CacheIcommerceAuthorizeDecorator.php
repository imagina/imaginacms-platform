<?php

namespace Modules\Icommerceauthorize\Repositories\Cache;

use Modules\Icommerceauthorize\Repositories\IcommerceAuthorizeRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheIcommerceAuthorizeDecorator extends BaseCacheDecorator implements IcommerceAuthorizeRepository
{
    public function __construct(IcommerceAuthorizeRepository $icommerceauthorize)
    {
        parent::__construct();
        $this->entityName = 'icommerceauthorize.icommerceauthorizes';
        $this->repository = $icommerceauthorize;
    }

    
    public function calculate($parameters,$conf)
    {
        return $this->remember(function () use ($parameters,$conf) {
            return $this->repository->calculate($parameters, $conf);
        });
    }
    
     /**
     * List or resources
     *
     * @return mixed
     */
    public function decriptUrl($eUrl)
    {
        return $this->remember(function () use ($eUrl) {
            return $this->repository->decriptUrl($eUrl);
        });
    }


}
