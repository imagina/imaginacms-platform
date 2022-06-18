<?php

namespace Modules\Isite\Http\Controllers\Api;

use Modules\Core\Icrud\Controllers\BaseCrudController;
//Model
use Modules\Isite\Entities\Domain;
use Modules\Isite\Repositories\DomainRepository;

class DomainApiController extends BaseCrudController
{
  public $model;
  public $modelRepository;

  public function __construct(Domain $model, DomainRepository $modelRepository)
  {
    $this->model = $model;
    $this->modelRepository = $modelRepository;
  }
}
