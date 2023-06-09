<?php

namespace Modules\Imeeting\Http\Controllers\Api;

use Modules\Core\Icrud\Controllers\BaseCrudController;
//Model Repository
use Modules\Imeeting\Entities\Meeting;
use Modules\Imeeting\Repositories\MeetingRepository;

class MeetingApiController extends BaseCrudController
{
    public $model;

    public $modelRepository;

    public function __construct(Meeting $model, MeetingRepository $modelRepository)
    {
        $this->model = $model;
        $this->modelRepository = $modelRepository;
    }
}
