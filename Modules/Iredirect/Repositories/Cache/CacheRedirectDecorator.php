<?php

namespace Modules\Iredirect\Repositories\Cache;

use Modules\Core\Repositories\Cache\BaseCacheDecorator;
use Modules\Iredirect\Repositories\Collection;
use Modules\Iredirect\Repositories\RedirectRepository;

class CacheRedirectDecorator extends BaseCacheDecorator implements RedirectRepository
{
    public function __construct(RedirectRepository $redirect)
    {
        parent::__construct();
        $this->entityName = 'redirects';
        $this->repository = $redirect;
    }

    /**
     * Get the previous redirect of the given redirect
     *
     * @param  object  $redirect
     */
    public function findBySlug($slug): object
    {
        return $this->cache
          ->tags([$this->entityName, 'global'])
          ->remember("{$this->locale}.{$this->entityName}.findBySlug.{$slug}", $this->cacheTime,
              function () use ($slug) {
                  return $this->repository->findBySlug($slug);
              }
          );
    }

    /**
     * Get the next redirect of the given redirect
     */
    public function find(object $id): object
    {
        return $this->cache
          ->tags([$this->entityName, 'global'])
          ->remember("{$this->locale}.{$this->entityName}.find.{$id}", $this->cacheTime,
              function () use ($id) {
                  return $this->repository->getNextOf($id);
              }
          );
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
