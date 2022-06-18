<?php

namespace Modules\Isite\Http\Controllers\Api;

use Modules\Core\Icrud\Controllers\BaseCrudController;
//Model
use Modules\Isite\Entities\Typeable;
use Modules\Isite\Repositories\TypeableRepository;

class TypeableApiController extends BaseCrudController
{
  public $model;
  public $modelRepository;

  public function __construct(Typeable $model, TypeableRepository $modelRepository)
  {
    $this->model = $model;
    $this->modelRepository = $modelRepository;
  }
}
