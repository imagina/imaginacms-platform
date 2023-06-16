<?php

namespace Modules\Requestable\Http\Controllers\Api;

use Modules\Core\Icrud\Controllers\BaseCrudController;
//Model
use Modules\Requestable\Entities\StatusHistory;
use Modules\Requestable\Repositories\StatusHistoryRepository;

class StatusHistoryApiController extends BaseCrudController
{
    public $model;

    public $modelRepository;

    public function __construct(StatusHistory $model, StatusHistoryRepository $modelRepository)
    {
        $this->model = $model;
        $this->modelRepository = $modelRepository;
    }
}
