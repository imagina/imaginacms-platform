<?php

namespace Modules\Requestable\Repositories\Cache;

use Modules\Requestable\Repositories\CategoryRepository;
use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;

class CacheCategoryDecorator extends BaseCacheCrudDecorator implements CategoryRepository
{
    public function __construct(CategoryRepository $category)
    {
        parent::__construct();
        $this->entityName = 'requestable.categories';
        $this->repository = $category;
    }
}
