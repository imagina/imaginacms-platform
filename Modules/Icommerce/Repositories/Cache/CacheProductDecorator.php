<?php

namespace Modules\Icommerce\Repositories\Cache;

use Modules\Core\Repositories\Cache\BaseCacheDecorator;
use Modules\Icommerce\Repositories\ProductRepository;

class CacheProductDecorator extends BaseCacheDecorator implements ProductRepository
{
    public function __construct(ProductRepository $product)
    {
        parent::__construct();
        $this->entityName = 'icommerce.products';
        $this->repository = $product;
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

    /**
     * Min and Max Price
     */
    public function getPriceRange($params): collection
    {
        return $this->remember(function () use ($params) {
            return $this->repository->getPriceRange($params);
        });
    }

    /**
     * Get Manufactures From Products Filtered
     */
    public function getManufacturers($params): collection
    {
        return $this->remember(function () use ($params) {
            return $this->repository->getManufacturers($params);
        });
    }

    /**
     * Get Product Options From Products Filtered
     */
    public function getProductOptions($params): collection
    {
        return $this->remember(function () use ($params) {
            return $this->repository->getProductOptions($params);
        });
    }
}
