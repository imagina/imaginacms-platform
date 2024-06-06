<?php

namespace Modules\Ilocations\Repositories\Cache;

use Modules\Ilocations\Repositories\ProvinceRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheProvinceDecorator extends BaseCacheDecorator implements ProvinceRepository
{
    public function __construct(ProvinceRepository $province)
    {
        parent::__construct();
        $this->entityName = 'ilocations.provinces';
        $this->repository = $province;
    }

    public function findByIso2($iso2)
    {
        return $this->remember(function () use ($iso2) {
            return $this->repository->findByIso2($iso2);
        });
    }

  public function index($page, $take, $filter, $include, $fields)
  {
    return $this->remember(function () use ($page, $take, $filter, $include, $fields) {
      return $this->repository->index($page, $take, $filter, $include, $fields);
    });
  }

  public function getItemsBy($params)
  {
    return $this->remember(function () use ($params) {
      return $this->repository->getItemsBy($params);
    });
  }

  public function getItem($criteria, $params)
  {
    return $this->remember(function () use ($criteria, $params) {
      return $this->repository->getItem($criteria, $params);
    });
  }
}
