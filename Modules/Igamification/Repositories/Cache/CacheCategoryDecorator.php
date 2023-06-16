<?php

namespace Modules\Igamification\Repositories\Cache;

use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;
use Modules\Igamification\Repositories\CategoryRepository;

class CacheCategoryDecorator extends BaseCacheCrudDecorator implements CategoryRepository
{
    public function __construct(CategoryRepository $category)
    {
        parent::__construct();
        $this->entityName = 'igamification.categories';
        $this->repository = $category;
    }

  public function bulkOrder($data, $params)
  {
      // TODO: Implement bulkOrder() method.
  }

  public function filterQuery($query, $filter, $params)
  {
      // TODO: Implement filterQuery() method.
  }

  public function syncModelRelations($model, $data)
  {
      // TODO: Implement syncModelRelations() method.
  }
}
