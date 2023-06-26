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
     * @return mixed
     */
    public function rootsForMenu(int $menuId)
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
     */
    public function getRootForMenu(int $menuId): object
    {
        return $this->remember(function () use ($menuId) {
            return $this->repository->getRootForMenu($menuId);
        });
    }

    /**
     * Return a complete tree for the given menu id
     */
    public function getTreeForMenu(int $menuId): object
    {
        return $this->remember(function () use ($menuId) {
            return $this->repository->getTreeForMenu($menuId);
        });
    }

    /**
     * Get all root elements
     */
    public function allRootsForMenu(int $menuId): object
    {
        return $this->remember(function () use ($menuId) {
            return $this->repository->allRootsForMenu($menuId);
        });
    }

    public function findByUriInLanguage(string $uri, string $locale): object
    {
        return $this->remember(function () use ($uri, $locale) {
            return $this->repository->findByUriInLanguage($uri, $locale);
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

    /**
     * Update the Menu Items for the given ids
     */
    public function updateItems(array $criterias, array $data): bool
    {
        $this->cache->tags($this->entityName)->flush();

        return $this->repository->updateItems($criterias, $data);
    }

    /**
     * Delete the Menu Items for the given ids
     */
    public function deleteItems(array $criterias): bool
    {
        $this->cache->tags($this->entityName)->flush();

        return $this->repository->deleteItems($criterias);
    }
}
