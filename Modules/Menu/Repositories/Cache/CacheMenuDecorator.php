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
     */
    public function allOnline(): object
    {
        return $this->remember(function () {
            return $this->repository->allOnline();
        });
    }

    /**
     * @return mixed
     */
    public function getItem($criteria, $params = false)
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
     * @return mixed
     */
    public function updateBy($criteria, $data, $params = false)
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
     * @return mixed
     */
    public function getItemsBy($params = false)
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
     * @return mixed
     */
    public function deleteBy($criteria, $params = false)
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
