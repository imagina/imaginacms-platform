<?php

namespace Modules\Iprofile\Repositories\Cache;

use Modules\Core\Repositories\Cache\BaseCacheDecorator;
use Modules\Iprofile\Repositories\SettingRepository;

class CacheSettingDecorator extends BaseCacheDecorator implements SettingRepository
{
    public function __construct(SettingRepository $departmentsetting)
    {
        parent::__construct();
        $this->entityName = 'iprofile.departmentsettings';
        $this->repository = $departmentsetting;
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
