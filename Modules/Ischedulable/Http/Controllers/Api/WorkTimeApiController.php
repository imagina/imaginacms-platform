<?php

namespace Modules\Ischedulable\Http\Controllers\Api;

use Modules\Core\Icrud\Controllers\BaseCrudController;
//Model
use Modules\Ischedulable\Entities\WorkTime;
use Modules\Ischedulable\Repositories\WorkTimeRepository;

class WorkTimeApiController extends BaseCrudController
{
    public $model;

    public $modelRepository;

    public function __construct(WorkTime $model, WorkTimeRepository $modelRepository)
    {
        $this->model = $model;
        $this->modelRepository = $modelRepository;
    }
}
