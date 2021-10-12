<?php

namespace Modules\Core\Icrud\Repositories\Cache;

use Illuminate\Cache\Repository;

use Modules\Core\Repositories\Cache\BaseCacheDecorator;
use Modules\Core\Icrud\Repositories\BaseCrudRepository;

abstract class BaseCacheCrudDecorator extends BaseCacheDecorator implements BaseCrudRepository
{
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

  public function updateBy($criteria, $data, $params)
  {
    $this->cache->tags($this->entityName)->flush();

    return $this->repository->updateBy($criteria, $data, $params);
  }

  public function deleteBy($criteria, $params)
  {
    $this->cache->tags($this->entityName)->flush();

    return $this->repository->deleteBy($criteria, $params);
  }

  public function restoreBy($criteria, $params)
  {
    $this->cache->tags($this->entityName)->flush();

    return $this->repository->restoreBy($criteria, $params);
  }
}
