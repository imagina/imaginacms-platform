<?php

namespace Modules\Iforms\Repositories\Cache;

use Modules\Core\Repositories\Cache\BaseCacheDecorator;
use Modules\Iforms\Repositories\FormRepository;

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
       * Find by System Name
       *
       * @return mixed
       */
      public function findBySystemName($systemName)
      {
          return $this->remember(function () use ($systemName) {
              return $this->repository->findBySystemName($systemName);
          });
      }
}
