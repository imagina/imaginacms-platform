<?php

namespace Modules\Requestable\Http\Controllers\Api;

use Modules\Core\Icrud\Controllers\BaseCrudController;
//Model
use Modules\Requestable\Entities\AutomationRule;
use Modules\Requestable\Repositories\AutomationRuleRepository;

class AutomationRuleApiController extends BaseCrudController
{
    public $model;

    public $modelRepository;

    public function __construct(AutomationRule $model, AutomationRuleRepository $modelRepository)
    {
        $this->model = $model;
        $this->modelRepository = $modelRepository;
    }
}
