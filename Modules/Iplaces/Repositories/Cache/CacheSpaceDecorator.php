<?php

namespace Modules\Iplaces\Repositories\Cache;

use Modules\Iplaces\Repositories\SpaceRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheSpaceDecorator extends BaseCacheDecorator implements SpaceRepository
{
    public function __construct(SpaceRepository $space)
    {
        parent::__construct();
        $this->entityName = 'iplaces.spaces';
        $this->repository = $space;
    }

    public function getItemsBy($params)
    {
        return $this->remember(function () use ($params) {
            return $this->repository->getItemsBy($params);
        });
    }

    public function getItem($criteria, $params = false)
    {
        return $this->remember(function () use ($criteria, $params) {
            return $this->repository->getItem($criteria, $params);
        });
    }


    public function updateBy($criteria, $data, $params = false)
    {
        return $this->remember(function () use ($criteria, $data, $params) {
            return $this->repository->updateBy($criteria, $data, $params);
        });
    }

    public function deleteBy($criteria, $params = false)
    {
        return $this->remember(function () use ($criteria, $params) {
            return $this->repository->deleteBy($criteria, $params);
        });
    }
}
