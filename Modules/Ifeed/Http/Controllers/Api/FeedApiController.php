<?php

namespace Modules\Ifeed\Http\Controllers\Api;

use Modules\Core\Icrud\Controllers\BaseCrudController;
//Model
use Modules\Ifeed\Entities\Feed;
use Modules\Ifeed\Repositories\FeedRepository;

class FeedApiController extends BaseCrudController
{
    public $model;

    public $modelRepository;

    public function __construct(Feed $model, FeedRepository $modelRepository)
    {
        $this->model = $model;
        $this->modelRepository = $modelRepository;
    }
}
