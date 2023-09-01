<?php

namespace Modules\Requestable\Http\Controllers\Api;

use Modules\Core\Icrud\Controllers\BaseCrudController;
//Model
use Modules\Requestable\Entities\Field;
use Modules\Requestable\Repositories\FieldRepository;

class FieldApiController extends BaseCrudController
{
    public $model;

    public $modelRepository;

    public function __construct(Field $model, FieldRepository $modelRepository)
    {
        $this->model = $model;
        $this->modelRepository = $modelRepository;
    }
}
