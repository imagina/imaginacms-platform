<?php

namespace Modules\Isite\Http\Controllers\Api;

use Modules\Core\Icrud\Controllers\BaseCrudController;
//Model
use Modules\Isite\Entities\Module;
use Modules\Isite\Repositories\ModuleRepository;

class ModuleApiController extends BaseCrudController
{
    public $model;

    public $modelRepository;

    public function __construct(Module $model, ModuleRepository $modelRepository)
    {
        $this->model = $model;
        $this->modelRepository = $modelRepository;
    }
}
