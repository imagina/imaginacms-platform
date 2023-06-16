<?php

namespace Modules\Iad\Repositories\Cache;

use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;
use Modules\Iad\Repositories\CategoryRepository;

class CacheCategoryDecorator extends BaseCacheCrudDecorator implements CategoryRepository
{
    public function __construct(CategoryRepository $category)
    {
        parent::__construct();
        $this->entityName = 'iad.categories';
        $this->repository = $category;
    }
}
