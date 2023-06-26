<?php

namespace Modules\Ievent\Repositories\Cache;

use Modules\Core\Repositories\Cache\BaseCacheDecorator;
use Modules\Ievent\Repositories\RecurrenceRepository;

class CacheRecurrenceDecorator extends BaseCacheDecorator implements RecurrenceRepository
{
    public function __construct(RecurrenceRepository $recurrence)
    {
        parent::__construct();
        $this->entityName = 'ievent.recurrences';
        $this->repository = $recurrence;
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
