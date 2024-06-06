<?php

namespace Modules\Ibuilder\Http\Controllers\Api;

use Modules\Core\Icrud\Controllers\BaseCrudController;
//Model
use Modules\Ibuilder\Entities\Template;
use Modules\Ibuilder\Repositories\TemplateRepository;

class TemplateApiController extends BaseCrudController
{
  public $model;
  public $modelRepository;

  public function __construct(Template $model, TemplateRepository $modelRepository)
  {
    $this->model = $model;
    $this->modelRepository = $modelRepository;
  }
}
