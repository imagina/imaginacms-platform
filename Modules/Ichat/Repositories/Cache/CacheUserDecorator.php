<?php

namespace Modules\Ichat\Repositories\Cache;

use Modules\Core\Repositories\Cache\BaseCacheDecorator;
use Modules\Ichat\Repositories\UserRepository;

class CacheUserDecorator extends BaseCacheDecorator implements UserRepository
{
    public function __construct(UserRepository $user)
    {
        parent::__construct();
        $this->entityName = 'ichat.users';
        $this->repository = $user;
    }

  /**
   * List or resources
   *
   * @return collection
   */
  public function getItemsBy($params): collection
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
  public function getItem($criteria, $params = false): object
  {
      return $this->remember(function () use ($criteria, $params) {
          return $this->repository->getItem($criteria, $params);
      });
  }
}
