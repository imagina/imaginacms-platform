<?php

namespace Modules\Iplan\Repositories\Cache;

use Modules\Core\Repositories\Cache\BaseCacheDecorator;
use Modules\Iplan\Repositories\LimitRepository;

class CacheLimitDecorator extends BaseCacheDecorator implements LimitRepository
{
    public function __construct(LimitRepository $limit)
    {
        parent::__construct();
        $this->entityName = 'iplan.limits';
        $this->repository = $limit;
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
