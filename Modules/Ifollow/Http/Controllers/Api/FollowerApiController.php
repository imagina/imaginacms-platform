<?php

namespace Modules\Ifollow\Http\Controllers\Api;

use Modules\Core\Icrud\Controllers\BaseCrudController;
//Model
use Modules\Ifollow\Entities\Follower;
use Modules\Ifollow\Repositories\FollowerRepository;

class FollowerApiController extends BaseCrudController
{
  public $model;
  public $modelRepository;

  public function __construct(Follower $model, FollowerRepository $modelRepository)
  {
    $this->model = $model;
    $this->modelRepository = $modelRepository;
  }
}
