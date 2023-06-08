<?php


namespace Modules\Iad\Http\Controllers\Api;

use Illuminate\Http\Request;
use Log;
use Mockery\CountValidator\Exception;
use Modules\Core\Icrud\Controllers\BaseCrudController;
use Modules\Iad\Entities\Ad;
use Modules\Iad\Entities\Up;
use Modules\Iad\Events\AdIsUpdating;
use Modules\Iad\Http\Requests\CreateUpRequest;
use Modules\Iad\Http\Requests\UpdateUpRequest;
use Modules\Iad\Repositories\UpRepository;
use Modules\Iad\Transformers\UpTransformer;
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;
use Modules\Iad\Http\Requests\CreateAdRequest;
use Modules\Iad\Http\Requests\UpdateAdRequest;
use Modules\Iad\Repositories\AdRepository;
use Modules\Iad\Transformers\AdTransformer;
use Route;
use Modules\Iad\Entities\AdStatus;

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
