<?php

namespace Modules\Iplan\Repositories\Cache;

use Modules\Iplan\Repositories\CategoryRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheCategoryDecorator extends BaseCacheDecorator implements CategoryRepository
{
  public function __construct(CategoryRepository $category)
  {
    parent::__construct();
    $this->entityName = 'iplan.categories';
    $this->repository = $category;
  }

  public function getItemsBy($params)
  {
    return $this->remember(function () use ($params) {
      return $this->repository->getItemsBy($params);
    });
  }

  public function getItem($criteria, $params = false)
  {
    return $this->remember(function () use ($criteria, $params) {
      return $this->repository->getItem($criteria, $params);
    });
  }


  public function updateBy($criteria, $data, $params = false)
  {
    return $this->remember(function () use ($criteria, $data, $params) {
      return $this->repository->updateBy($criteria, $data, $params);
    });
  }

  public function deleteBy($criteria, $params = false)
  {
    return $this->remember(function () use ($criteria, $params) {
      return $this->repository->deleteBy($criteria, $params);
    });
  }

}
