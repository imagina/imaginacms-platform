<?php

namespace Modules\Icommercecoordinadora\Repositories\Cache;

use Modules\Icommercecoordinadora\Repositories\IcommerceCoordinadoraRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheIcommerceCoordinadoraDecorator extends BaseCacheDecorator implements IcommerceCoordinadoraRepository
{
    public function __construct(IcommerceCoordinadoraRepository $icommercecoordinadora)
    {
        parent::__construct();
        $this->entityName = 'icommercecoordinadora.icommercecoordinadoras';
        $this->repository = $icommercecoordinadora;
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
