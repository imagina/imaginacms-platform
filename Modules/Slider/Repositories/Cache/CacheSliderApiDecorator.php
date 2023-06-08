<?php namespace Modules\Slider\Repositories\Cache;

use Modules\Core\Repositories\Cache\BaseCacheDecorator;
use Modules\Slider\Repositories\SliderApiRepository;
use Modules\Slider\Repositories\SliderRepository;

class CacheSliderApiDecorator extends BaseCacheDecorator implements SliderApiRepository
{
  /**
   * @var SliderRepository
   */
  protected $repository;
  
  public function __construct(SliderApiRepository $slider)
  {
    parent::__construct();
    $this->entityName = 'sliders';
    $this->repository = $slider;
  }
  
  /**
   * Get all online sliders
   * @return object
   */
  /* DEPRECATED
  public function allOnline()
  {
    return $this->cache
      ->tags($this->entityName, 'global')
      ->remember("{$this->locale}.{$this->entityName}.allOnline", $this->cacheTime,
        function () {
          return $this->repository->allOnline();
        }
      );
  }*/
  
  public function getItemsBy($params)
  {
    return $this->remember(function () use ($params) {
      return $this->repository->getItemsBy($params);
    });
  }
  
  public function updateBy($criteria, $data, $params = false)
  {
    $this->clearCache();
    
    return $this->repository->updateBy($criteria, $data, $params);
  }
  
  public function index($page, $take, $filter, $include)
  {
    return $this->remember(function () use ($page, $take, $filter, $include) {
      return $this->repository->index($page, $take, $filter, $include);
    });
  }
  
  public function getItem($criteria, $params = false)
  {
    return $this->remember(function () use ($criteria, $params) {
      return $this->repository->getItem($criteria, $params);
    });
  }
  
  public function show($id, $include)
  {
    return $this->remember(function () use ($id, $include) {
      return $this->repository->show($id, $include);
    });
  }
  
  public function deleteBy($criteria, $params = false)
  {
    $this->clearCache();
    
    return $this->repository->deleteBy($criteria, $params);
  }
  
 
}
