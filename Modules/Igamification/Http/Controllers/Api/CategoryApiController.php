<?php

namespace Modules\Igamification\Http\Controllers\Api;

use Modules\Core\Icrud\Controllers\BaseCrudController;
//Model
use Modules\Igamification\Entities\Category;
use Modules\Igamification\Repositories\CategoryRepository;

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
