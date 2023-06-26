<?php

namespace Modules\Icommerce\Repositories\Cache;

use Modules\Core\Repositories\Cache\BaseCacheDecorator;
use Modules\Icommerce\Repositories\TaxClassRepository;

class CacheTaxClassDecorator extends BaseCacheDecorator implements TaxClassRepository
{
    public function __construct(TaxClassRepository $taxclass)
    {
        parent::__construct();
        $this->entityName = 'icommerce.taxclasses';
        $this->repository = $taxclass;
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
}
