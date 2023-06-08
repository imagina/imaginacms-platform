<?php

namespace Modules\Iauctions\Repositories\Cache;

use Modules\Iauctions\Repositories\CategoryRepository;
use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;

class CacheCategoryDecorator extends BaseCacheCrudDecorator implements CategoryRepository
{
    public function __construct(CategoryRepository $category)
    {
        parent::__construct();
        $this->entityName = 'iauctions.categories';
        $this->repository = $category;
    }
}
