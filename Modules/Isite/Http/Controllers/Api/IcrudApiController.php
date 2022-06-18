<?php

namespace Modules\Isite\Http\Controllers\Api;

use Modules\Core\Icrud\Controllers\BaseCrudController;
//Model
use Modules\Isite\Entities\Icrud;
use Modules\Isite\Repositories\IcrudRepository;

class IcrudApiController extends BaseCrudController
{
  public $model;
  public $modelRepository;

  public function __construct(Icrud $model, IcrudRepository $modelRepository)
  {
    $this->model = $model;
    $this->modelRepository = $modelRepository;
  }
}
