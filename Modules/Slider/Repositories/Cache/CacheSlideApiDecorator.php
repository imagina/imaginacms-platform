<?php namespace Modules\Slider\Repositories\Cache;

use Modules\Core\Repositories\Cache\BaseCacheDecorator;
use Modules\Slider\Repositories\SlideApiRepository;

class CacheSlideApiDecorator extends BaseCacheDecorator implements SlideApiRepository
{
  /**
   * @var SliderRepository
   */
  protected $repository;
  
  public function __construct(SlideApiRepository $slide)
  {
    parent::__construct();
    $this->entityName = 'slides';
    $this->repository = $slide;
  }
  
  /**
   * Get all online sliders
   * @return object
   */
  /*DEPRECATED
  public function allOnline()
  {
      return $this->remember(function () {
          return $this->repository->allOnline();
      });
  }*/
  
  /**
   * @param $id
   * @param $include
   * @return mixed
   */
  public function show($id, $include)
  {
    return $this->remember(function () use ($id, $include) {
      return $this->repository->index($id, $include);
    });
  }
  
  /**
   * @param $page
   * @param $take
   * @param $filter
   * @param $include
   * @return array|mixed
   */
  public function index($page, $take, $filter, $include)
  {
    return $this->remember(function () use ($page, $take, $filter, $include) {
      return $this->repository->index($page, $take, $filter, $include);
    });
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
   * @param $criteria
   * @param $data
   * @param $params
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
   * @param $criteria
   * @param $params
   * @return mixed
   */
  public function deleteBy($criteria, $params = false)
  {
    $this->clearCache();
    
    return $this->repository->deleteBy($criteria, $params);
  }
}
