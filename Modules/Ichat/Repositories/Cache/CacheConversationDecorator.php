<?php

namespace Modules\Ichat\Repositories\Cache;

use Modules\Core\Repositories\Cache\BaseCacheDecorator;
use Modules\Ichat\Repositories\ConversationRepository;

class CacheConversationDecorator extends BaseCacheDecorator implements ConversationRepository
{
    public function __construct(ConversationRepository $conversation)
    {
        parent::__construct();
        $this->entityName = 'ichat.conversations';
        $this->repository = $conversation;
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
