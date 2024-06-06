<?php

namespace Modules\Ilocations\Repositories\Cache;

use Modules\Ilocations\Repositories\CityRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheCityDecorator extends BaseCacheDecorator implements CityRepository
{
    public function __construct(CityRepository $city)
    {
        parent::__construct();
        $this->entityName = 'ilocations.cities';
        $this->repository = $city;
    }


    public function whereByCountry($id)
    {

        return $this->remember(function () use ($id) {
            return $this->repository->whereByCountry($id);
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
