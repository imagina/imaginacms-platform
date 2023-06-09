<?php

namespace Modules\Ifillable\Http\Controllers\Api;

use Modules\Core\Icrud\Controllers\BaseCrudController;
//Model
use Modules\Ifillable\Entities\Field;
use Modules\Ifillable\Repositories\FieldRepository;

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
