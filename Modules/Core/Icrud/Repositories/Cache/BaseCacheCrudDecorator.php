<?php

namespace Modules\Core\Icrud\Repositories\Cache;

use Illuminate\Cache\Repository;

use Modules\Core\Repositories\Cache\BaseCacheDecorator;
use Modules\Core\Icrud\Repositories\BaseCrudRepository;

abstract class BaseCacheCrudDecorator extends BaseCacheDecorator implements BaseCrudRepository
{
  public function getItemsBy($params)
  {
    
    $query = $this->repository->getOrCreateQuery($params);
    
    return $this->remember(function () use ($params) {
      return $this->repository->getItemsBy($params);
    },$this->createKey($query, $params));
  }

  public function getItem($criteria, $params = false)
  {
    
    $query = $this->repository->getOrCreateQuery($params, $criteria);

    return $this->remember(function () use ($criteria, $params) {
      return $this->repository->getItem($criteria, $params);
    },$this->createKey($query, $params));
  }

  public function updateBy($criteria, $data, $params = false)
  {
    $this->cache->tags($this->entityName)->flush();

    return $this->repository->updateBy($criteria, $data, $params);
  }

  public function deleteBy($criteria, $params = false)
  {
    $this->cache->tags($this->entityName)->flush();

    return $this->repository->deleteBy($criteria, $params);
  }

  public function restoreBy($criteria, $params = false)
  {
    $this->cache->tags($this->entityName)->flush();

    return $this->repository->restoreBy($criteria, $params);
  }
  
  public function createKey($query, $params){
    
    return ($query->toSql() ?? "" .
      \serialize($query->getBindings() ?? "") .
      \serialize($params->filter ?? "") .
      \serialize($params->order ?? "") .
      \serialize($params->include ?? "") .
      \serialize($params->page ?? "") .
      \serialize($params->take ?? ""));
  }
}
