<?php

namespace Modules\Isite\Http\Controllers\Api;

use Modules\Core\Icrud\Controllers\BaseCrudController;
//Model
use Modules\Isite\Entities\Category;
use Modules\Isite\Repositories\CategoryRepository;

class CategoryApiController extends BaseCrudController
{
  public $model;
  public $modelRepository;

  public function __construct(Category $model, CategoryRepository $modelRepository)
  {
    $this->model = $model;
    $this->modelRepository = $modelRepository;
  }
}
