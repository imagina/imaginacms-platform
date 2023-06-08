<?php

namespace Modules\Requestable\Http\Controllers\Api;

use Modules\Core\Icrud\Controllers\BaseCrudController;
//Model
use Modules\Requestable\Entities\CategoryRule;
use Modules\Requestable\Repositories\CategoryRuleRepository;

class CategoryRuleApiController extends BaseCrudController
{
  public $model;
  public $modelRepository;

  public function __construct(CategoryRule $model, CategoryRuleRepository $modelRepository)
  {
    $this->model = $model;
    $this->modelRepository = $modelRepository;
  }
}
