<?php


namespace Modules\Iad\Http\Controllers\Api;

use Illuminate\Http\Request;
use Log;
use Mockery\CountValidator\Exception;
use Modules\Core\Icrud\Controllers\BaseCrudController;
use Modules\Iad\Entities\Ad;
use Modules\Iad\Events\AdIsUpdating;
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;
use Modules\Iad\Http\Requests\CreateAdRequest;
use Modules\Iad\Http\Requests\UpdateAdRequest;
use Modules\Iad\Repositories\AdRepository;
use Modules\Iad\Transformers\AdTransformer;
use Route;
use Modules\Iad\Entities\AdStatus;

class AdApiController extends BaseCrudController
{
  private $ad;
  private $field;
  public $model;
  public $modelRepository;
  public function __construct(Ad $model, AdRepository $modelRepository)
  {
    parent::__construct();
    $this->model = $model;
    $this->modelRepository = $modelRepository;
  }
  
  /**
   * GET ITEMS
   *
   * @return mixed
   */
  public function indexStatus(Request $request)
  {
    try {
      //Get Parameters from URL.
      $params = $this->getParamsRequest($request);

      //Request to Repository
      $adStatus = new AdStatus();

      //Response
      $response = ["data" => $adStatus->get()];
    } catch (\Exception $e) {
      $status = $this->getStatusError($e->getCode());
      $response = ["errors" => $e->getMessage()];
    }

    //Return response
    return response()->json($response, $status ?? 200);
  }
  
}
