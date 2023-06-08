<?php

namespace Modules\Iblog\Http\Controllers\Api;

use Log;
use Mockery\CountValidator\Exception;
use Modules\Core\Icrud\Controllers\BaseCrudController;
use Modules\Iblog\Entities\Category;
use Modules\Iblog\Repositories\CategoryRepository;
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;
use Route;

class CategoryApiController extends BaseCrudController
{
  /**
   *
   * @var CategoryRepository
   */
  public $model;
  public $modelRepository;
  
  public function __construct(Category $model, CategoryRepository $modelRepository)
  {
    $this->model = $model;
    $this->modelRepository = $modelRepository;
  }
  

}
