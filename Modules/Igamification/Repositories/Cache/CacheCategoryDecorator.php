<?php

namespace Modules\Igamification\Repositories\Cache;

use Modules\Igamification\Repositories\CategoryRepository;
use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;

class CacheCategoryDecorator extends BaseCacheCrudDecorator implements CategoryRepository
{
    public function __construct(CategoryRepository $category)
    {
        parent::__construct();
        $this->entityName = 'igamification.categories';
        $this->repository = $category;
    }
}
