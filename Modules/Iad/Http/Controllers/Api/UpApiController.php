<?php

namespace Modules\Iad\Http\Controllers\Api;

use Modules\Core\Icrud\Controllers\BaseCrudController;
use Modules\Iad\Entities\Up;
use Modules\Iad\Repositories\UpRepository;

class UpApiController extends BaseCrudController
{
    public $model;

    public $modelRepository;

    public function __construct(Up $model, UpRepository $modelRepository)
    {
        $this->model = $model;
        $this->modelRepository = $modelRepository;
    }
}
