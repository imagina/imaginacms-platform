<?php

namespace Modules\Ibooking\Repositories\Cache;

use Modules\Ibooking\Repositories\CategoryRepository;
use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;

class CacheCategoryDecorator extends BaseCacheCrudDecorator implements CategoryRepository
{
    public function __construct(CategoryRepository $category)
    {
        parent::__construct();
        $this->entityName = 'ibooking.categories';
        $this->repository = $category;
    }
}
