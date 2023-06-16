<?php

namespace Modules\Iblog\Http\Controllers\Api;

use Modules\Core\Icrud\Controllers\BaseCrudController;
use Modules\Iblog\Entities\Post;
use Modules\Iblog\Repositories\PostRepository;

class PostApiController extends BaseCrudController
{
    public $model;

    public $modelRepository;

    public function __construct(Post $model, PostRepository $modelRepository)
    {
        $this->model = $model;
        $this->modelRepository = $modelRepository;
    }
}
