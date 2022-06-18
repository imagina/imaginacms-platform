<?php

namespace Modules\Isite\Http\Controllers\Api;

use Modules\Core\Icrud\Controllers\BaseCrudController;
//Model
use Modules\Isite\Entities\Layout;
use Modules\Isite\Repositories\LayoutRepository;

class LayoutApiController extends BaseCrudController
{
  public $model;
  public $modelRepository;

  public function __construct(Layout $model, LayoutRepository $modelRepository)
  {
    $this->model = $model;
    $this->modelRepository = $modelRepository;
  }
}
