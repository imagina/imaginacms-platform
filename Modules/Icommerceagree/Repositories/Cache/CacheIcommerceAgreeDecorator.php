<?php

namespace Modules\Icommerceagree\Repositories\Cache;

use Modules\Icommerceagree\Repositories\IcommerceAgreeRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheIcommerceAgreeDecorator extends BaseCacheDecorator implements IcommerceAgreeRepository
{
    public function __construct(IcommerceAgreeRepository $icommerceagree)
    {
        parent::__construct();
        $this->entityName = 'icommerceagree.icommerceagrees';
        $this->repository = $icommerceagree;
    }

    /**
   * List or resources
   *
   * @return mixed
   */
    public function calculate($parameters,$conf)
    {
        return $this->remember(function () use ($parameters,$conf) {
            return $this->repository->calculate($parameters,$conf);
        });
    }

}
