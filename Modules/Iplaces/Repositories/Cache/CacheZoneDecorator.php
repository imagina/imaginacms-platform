<?php

namespace Modules\Iplaces\Repositories\Cache;

use Modules\Core\Repositories\Cache\BaseCacheDecorator;
use Modules\Iplaces\Repositories\ZoneRepository;

class CacheZoneDecorator extends BaseCacheDecorator implements ZoneRepository
{
    public function __construct(ZoneRepository $zone)
    {
        parent::__construct();
        $this->entityName = 'iplaces.zones';
        $this->repository = $zone;
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
