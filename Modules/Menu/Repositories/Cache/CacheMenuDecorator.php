<?php

namespace Modules\Menu\Repositories\Cache;

use Modules\Core\Repositories\Cache\BaseCacheDecorator;
use Modules\Menu\Repositories\MenuRepository;

class CacheMenuDecorator extends BaseCacheDecorator implements MenuRepository
{
    /**
     * @var MenuRepository
     */
    protected $repository;

    public function __construct(MenuRepository $menu)
    {
        parent::__construct();
        $this->entityName = 'menus';
        $this->repository = $menu;
    }

    /**
     * Get all online menus
     * @return object
     */
    public function allOnline()
    {
        return $this->remember(function () {
            return $this->repository->allOnline();
        });
    }

    /**
     * @param $criteria
     * @param $params
     * @return mixed
     */
    public function getItem($criteria, $params)
    {
        return $this->cache
            ->tags([$this->entityName, 'global'])
            ->remember("{$this->entityName}.getItem.{$criteria}", $this->cacheTime,
                function () use ($criteria, $params) {
                    return $this->repository->getItem($criteria, $params);
                }
            );
    }

    /**
     * @param $criteria
     * @param $data
     * @param $params
     * @return mixed
     */
    public function updateBy($criteria, $data, $params)
    {
        $this->cache->tags($this->entityName)->flush();
        return $this->cache
            ->tags([$this->entityName, 'global'])
            ->remember("{$this->entityName}.getItem.{$criteria}", $this->cacheTime,
                function () use ($criteria, $data, $params) {
                    return $this->repository->updateBy($criteria, $data, $params);
                }
            );
    }

    /**
     * @param $params
     * @return mixed
     */
    public function getItemsBy($params)
    {
        return $this->cache
            ->tags([$this->entityName, 'global'])
            ->remember("{$this->entityName}.getItemBy", $this->cacheTime,
                function () use ($params) {
                    return $this->repository->getItemsBy($params);
                }
            );
    }

    /**
     * @param $criteria
     * @param $params
     * @return mixed
     */
    public function deleteBy($criteria, $params)
    {
        $this->cache->tags($this->entityName)->flush();
        return $this->cache
            ->tags([$this->entityName, 'global'])
            ->remember("{$this->entityName}.deleteBy.{$criteria}", $this->cacheTime,
                function () use ($criteria, $params) {
                    return $this->repository->deleteBy($criteria, $params);
                }
            );
    }
}
