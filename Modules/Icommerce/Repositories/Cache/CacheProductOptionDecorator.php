<?php

namespace Modules\Icommerce\Repositories\Cache;

use Modules\Core\Repositories\Cache\BaseCacheDecorator;
use Modules\Icommerce\Repositories\ProductOptionRepository;

class CacheProductOptionDecorator extends BaseCacheDecorator implements ProductOptionRepository
{
    public function __construct(ProductOptionRepository $productoption)
    {
        parent::__construct();
        $this->entityName = 'icommerce.productoptions';
        $this->repository = $productoption;
    }

  /**
   * List or resources
   */
  public function getItemsBy($params): collection
  {
      return $this->remember(function () use ($params) {
          return $this->repository->getItemsBy($params);
      });
  }

  /**
   * find a resource by id or slug
   */
  public function getItem($criteria, $params = false): object
  {
      return $this->remember(function () use ($criteria, $params) {
          return $this->repository->getItem($criteria, $params);
      });
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
