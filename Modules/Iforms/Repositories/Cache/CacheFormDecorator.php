<?php

namespace Modules\Iforms\Repositories\Cache;

use Modules\Iforms\Repositories\FormRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheFormDecorator extends BaseCacheDecorator implements FormRepository
{
  public function __construct(FormRepository $form)
  {
    parent::__construct();
    $this->entityName = 'iforms.forms';
    $this->repository = $form;
  }

    /**
     * List or resources
     *
     * @param $params
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
     * @param $criteria
     * @param $params
     * @return object
     */
  public function getItem($criteria, $params)
  {
    return $this->remember(function () use ($criteria, $params) {
      return $this->repository->getItem($criteria, $params);
    });
  }


    /**
     * Find by System Name
     * @param $systemName
     * @return mixed
     */
    public function findBySystemName($systemName)
    {
        return $this->remember(function () use ($systemName) {
            return $this->repository->findBySystemName($systemName);
        });
    }
}
