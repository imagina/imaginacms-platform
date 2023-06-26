<?php

namespace Modules\Iblog\Repositories\Cache;

use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;
use Modules\Iblog\Repositories\PostRepository;

class CachePostDecorator extends BaseCacheCrudDecorator implements PostRepository
{
    public function __construct(PostRepository $post)
    {
        parent::__construct();
        $this->entityName = 'iblog.posts';
        $this->repository = $post;
    }

    public function whereCategory(object $id): object
    {
        return $this->remember(function () use ($id) {
            return $this->repository->whereCategory($id);
        });
    }

    /**
     * @return mixed
     */
    public function getItemsBy($params)
    {
        return $this->remember(function () use ($params) {
            return $this->repository->getItemsBy($params);
        });
    }

    /**
     * @return mixed
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
     * destroy a resource
     *
     * @return mixed
     */
    public function deleteBy($criteria, $params = false)
    {
        $this->clearCache();

        return $this->repository->deleteBy($criteria, $params);
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
}
