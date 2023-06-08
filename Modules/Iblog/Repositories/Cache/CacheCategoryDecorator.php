<?php

namespace Modules\Iblog\Repositories\Cache;

use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;
use Modules\Iblog\Repositories\CategoryRepository;

class CacheCategoryDecorator extends BaseCacheCrudDecorator implements CategoryRepository
{
  public function __construct(CategoryRepository $category)
  {
    parent::__construct();
    $this->entityName = 'iblog.categories';
    $this->repository = $category;
  }
  
}
