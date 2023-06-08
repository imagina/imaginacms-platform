<?php

namespace Modules\Iplan\Http\Controllers\Api;

use Modules\Core\Icrud\Controllers\BaseCrudController;
//Model
use Illuminate\Http\Request;
use Modules\Iplan\Entities\Plan;
use Modules\Iplan\Repositories\PlanRepository;

class PlanApiController extends BaseCrudController
{
  public $model;
  public $modelRepository;

  public function __construct(Plan $model, PlanRepository $modelRepository)
  {
    $this->model = $model;
    $this->modelRepository = $modelRepository;
  }
  
  
  /**
   * GET PLAN FREQUENCIES
   *
   * @return mixed
   */
  public function frequencies(Request $request)
  {
    try {
      //Response
      $response = [
        "data" => app('Modules\Iplan\Entities\Frequency')->lists()
      ];
    } catch (\Exception $e) {
      $status = $this->getStatusError($e->getCode());
      $response = ["errors" => $e->getMessage()];
    }
    
    //Return response
    return response()->json($response, $status ?? 200);
  }
  
  /**
   * GET ITEMS
   *
   * @return mixed
   */
  public function modules(Request $request)
  {
    try {
      
      $modulesEnabled = app('modules')->allEnabled();
      $data = [];
      
      foreach($modulesEnabled as $name=>$module){
        $cfg = config('asgard.'.strtolower($name).'.config.limitableEntities');
        if(!empty($cfg)) {
          $data[] = [
            'label' => $name,
            'value' => $name,
            'entities' => $cfg
          ];
        }
      }
      
      //Response
      $response = [
        "data" => $data,
      ];
    } catch (\Exception $e) {
      $status = $this->getStatusError($e->getCode());
      $response = ["errors" => $e->getMessage()];
    }
    
    //Return response
    return response()->json($response, $status ?? 200);
  }
}
