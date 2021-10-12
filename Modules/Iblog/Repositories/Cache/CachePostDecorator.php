<?php

namespace Modules\Iblog\Repositories\Cache;

use Modules\Iblog\Repositories\Collection;
use Modules\Iblog\Repositories\PostRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CachePostDecorator extends BaseCacheDecorator implements PostRepository
{
  public function __construct(PostRepository $post)
  {
    parent::__construct();
    $this->entityName = 'posts';
    $this->repository = $post;
  }
  
  
  /**
   * @param object $id
   * @return object
   */
  public function whereCategory($id)
  {
    return $this->remember(function () use ($id) {
      return $this->repository->whereCategory($id);
    });
  }
  
  /**
   * @param $params
   * @return mixed
   */
  public function getItemsBy($params)
  {
    return $this->remember(function () use ($params) {
      return $this->repository->getItemsBy($params);
    });
  }
  
  /**
   * @param $criteria
   * @param $params
   * @return mixed
   */
  public function getItem($criteria, $params)
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
   * destroy a resource
   *
   * @return mixed
   */
  public function deleteBy($criteria, $params)
  {
    $this->clearCache();
    
    return $this->repository->deleteBy($criteria, $params);
  }
  
  
  /**
   * update a resource
   *
   * @return mixed
   */
  public function updateBy($criteria, $data, $params)
  {
    $this->clearCache();
    
    return $this->repository->updateBy($criteria, $data, $params);
  }
  
  
}
