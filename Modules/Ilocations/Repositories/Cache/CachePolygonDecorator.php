<?php

namespace Modules\Ilocations\Repositories\Cache;

use Modules\Ilocations\Repositories\PolygonRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CachePolygonDecorator extends BaseCacheDecorator implements PolygonRepository
{
  public function __construct(PolygonRepository $polygon)
  {
    parent::__construct();
    $this->entityName = 'ilocations.polygons';
    $this->repository = $polygon;
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
