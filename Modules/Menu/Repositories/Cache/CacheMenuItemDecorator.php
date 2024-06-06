<?php

namespace Modules\Menu\Repositories\Cache;

use Modules\Core\Repositories\Cache\BaseCacheDecorator;
use Modules\Menu\Repositories\MenuItemRepository;

class CacheMenuItemDecorator extends BaseCacheDecorator implements MenuItemRepository
{
    /**
     * @var MenuItemRepository
     */
    protected $repository;

    public function __construct(MenuItemRepository $menuItem)
    {
        parent::__construct();
        $this->entityName = 'menusItems';
        $this->repository = $menuItem;
    }

    /**
     * Get all root elements
     *
     * @param  int   $menuId
     * @return mixed
     */
    public function rootsForMenu($menuId)
    {
        return $this->remember(function () use ($menuId) {
            return $this->repository->rootsForMenu($menuId);
        });
    }

    /**
     * Get the menu items ready for routes
     *
     * @return mixed
     */
    public function getForRoutes()
    {
        return $this->remember(function () {
            return $this->repository->getForRoutes();
        });
    }

    /**
     * Get the root menu item for the given menu id
     *
     * @param  int    $menuId
     * @return object
     */
    public function getRootForMenu($menuId)
    {
        return $this->remember(function () use ($menuId) {
            return $this->repository->getRootForMenu($menuId);
        });
    }

    /**
     * Return a complete tree for the given menu id
     *
     * @param  int    $menuId
     * @return object
     */
    public function getTreeForMenu($menuId)
    {
        return $this->remember(function () use ($menuId) {
            return $this->repository->getTreeForMenu($menuId);
        });
    }

    /**
     * Get all root elements
     *
     * @param  int    $menuId
     * @return object
     */
    public function allRootsForMenu($menuId)
    {
        return $this->remember(function () use ($menuId) {
            return $this->repository->allRootsForMenu($menuId);
        });
    }

    /**
     * @param  string $uri
     * @param  string $locale
     * @return object
     */
    public function findByUriInLanguage($uri, $locale)
    {
        return $this->remember(function () use ($uri, $locale) {
            return $this->repository->findByUriInLanguage($uri, $locale);
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
    /**
     * Update the Menu Items for the given ids
     * @param array $criterias
     * @param array $data
     * @return bool
     */
    public function updateItems($criterias, $data)
    {
        $this->cache->tags($this->entityName)->flush();

        return $this->repository->updateItems($criterias, $data);
    }

    /**
     * Delete the Menu Items for the given ids
     * @param array $criterias
     * @return bool
     */
    public function deleteItems($criterias)
    {
        $this->cache->tags($this->entityName)->flush();

        return $this->repository-> deleteItems($criterias);
    }
}
