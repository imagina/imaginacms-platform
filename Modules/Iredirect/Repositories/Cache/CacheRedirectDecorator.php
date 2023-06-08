<?php

namespace Modules\Iredirect\Repositories\Cache;

use Modules\Iredirect\Repositories\Collection;
use Modules\Iredirect\Repositories\RedirectRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheRedirectDecorator extends BaseCacheDecorator implements RedirectRepository
{
  public function __construct(RedirectRepository $redirect)
  {
    parent::__construct();
    $this->entityName = 'redirects';
    $this->repository = $redirect;
  }
  
  /**
   * Get the previous redirect of the given redirect
   * @param object $redirect
   * @return object
   */
  public function findBySlug($slug)
  {
    return $this->cache
      ->tags([$this->entityName, 'global'])
      ->remember("{$this->locale}.{$this->entityName}.findBySlug.{$slug}", $this->cacheTime,
        function () use ($slug) {
          return $this->repository->findBySlug($slug);
        }
      );
  }
  
  /**
   * Get the next redirect of the given redirect
   * @param object $id
   * @return object
   */
  public function find($id)
  {
    return $this->cache
      ->tags([$this->entityName, 'global'])
      ->remember("{$this->locale}.{$this->entityName}.find.{$id}", $this->cacheTime,
        function () use ($id) {
          return $this->repository->getNextOf($id);
        }
      );
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
  
}
