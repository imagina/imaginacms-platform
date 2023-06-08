<?php

namespace Modules\Notification\Repositories\Cache;

use Modules\Notification\Repositories\RuleRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheRuleDecorator extends BaseCacheDecorator implements RuleRepository
{
  public function __construct(RuleRepository $rule)
  {
    parent::__construct();
    $this->entityName = 'notification.rules';
    $this->repository = $rule;
  }
  
  /**
   * List or resources
   *
   * @return collection
   */
  public function getItemsBy($params)
  {
    return $this->remember(function () use ($params) {
      return $this->repository->getItemsBy($params);
    });
  }
  
  /**
   * find a resource by id or slug
   *
   * @return object
   */
  public function getItem($criteria, $params = false)
  {
    return $this->remember(function () use ($criteria, $params) {
      return $this->repository->getItem($criteria, $params);
    });
  }
  
  /**
   * create a resource
   *
   * @return mixed
   */
  public function create($data)
  {
    $this->clearCache();
    return $this->repository->create($data);
  }
  
  /**
   * update a resource
   *
   * @return mixed
   */
  public function updateBy($criteria, $data, $params = false)
  {
    $this->clearCache();
    
    return $this->repository->updateBy($criteria, $data, $params);
  }
  
  /**
   * destroy a resource
   *
   * @return mixed
   */
  public function deleteBy($criteria, $params = false)
  {
    $this->clearCache();
    
    return $this->repository->deleteBy($criteria, $params);
  }
  
  /**
   * destroy a resource
   *
   * @return mixed
   */
  public function moduleConfigs($modules)
  {
    //$this->clearCache();
    
    return $this->repository->moduleConfigs($modules);
  }
  
}
