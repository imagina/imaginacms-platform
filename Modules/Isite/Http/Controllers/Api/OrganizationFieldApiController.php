<?php

namespace Modules\Isite\Http\Controllers\Api;

use Modules\Core\Icrud\Controllers\BaseCrudController;
//Model
use Modules\Isite\Entities\OrganizationField;
use Modules\Isite\Repositories\OrganizationFieldRepository;

class OrganizationFieldApiController extends BaseCrudController
{
  public $model;
  public $modelRepository;

  public function __construct(OrganizationField $model, OrganizationFieldRepository $modelRepository)
  {
    $this->model = $model;
    $this->modelRepository = $modelRepository;
  }
}
