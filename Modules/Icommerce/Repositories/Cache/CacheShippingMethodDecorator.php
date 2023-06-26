<?php

namespace Modules\Icommerce\Repositories\Cache;

use Modules\Core\Repositories\Cache\BaseCacheDecorator;
use Modules\Icommerce\Repositories\ShippingMethodRepository;

class CacheShippingMethodDecorator extends BaseCacheDecorator implements ShippingMethodRepository
{
    public function __construct(ShippingMethodRepository $shippingmethod)
    {
        parent::__construct();
        $this->entityName = 'icommerce.shippingmethods';
        $this->repository = $shippingmethod;
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

    public function getCalculations($request, $params)
    {
        return $this->remember(function () use ($request, $params) {
            return $this->repository->getCalculations($request, $params);
        });
    }
}
