<?php


namespace Modules\Iad\Http\Controllers\Api;

use Illuminate\Http\Request;
use Log;
use Mockery\CountValidator\Exception;
use Modules\Core\Icrud\Controllers\BaseCrudController;
use Modules\Iad\Entities\Category;
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;
use Modules\Iad\Http\Requests\CreateCategoryRequest;
use Modules\Iad\Http\Requests\UpdateCategoryRequest;
use Modules\Iad\Repositories\CategoryRepository;
use Modules\Iad\Transformers\CategoryTransformer;
use Route;

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
