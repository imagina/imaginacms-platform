<?php

namespace Modules\Icommerceflatrate\Repositories\Cache;

use Modules\Icommerceflatrate\Repositories\IcommerceFlatrateRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheIcommerceFlatrateDecorator extends BaseCacheDecorator implements IcommerceFlatrateRepository
{
    public function __construct(IcommerceFlatrateRepository $icommerceflatrate)
    {
        parent::__construct();
        $this->entityName = 'icommerceflatrate.icommerceflatrates';
        $this->repository = $icommerceflatrate;
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
