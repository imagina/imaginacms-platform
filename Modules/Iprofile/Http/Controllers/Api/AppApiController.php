<?php

namespace Modules\Iprofile\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;
use Modules\User\Permissions\PermissionManager;

class AppApiController extends BaseApiController
{

  private $address;
  private $permissions;

  public function __construct(PermissionManager $permissions)
  {
    $this->permissions = $permissions;
  }

  /**
   * Return Version to front-end
   *
   * @param Request $request
   * @return mixed
   */
  public function version(Request $request)
  {
    try {
      $response = ["data" => config('asgard.iprofile.config.frontendVersion')];
    } catch (\Exception $e) {
      $status = $this->getStatusError($e->getCode());
      $response = ["errors" => $e->getMessage()];
    }

    //Return response
    return response()->json($response, $status ?? 200);
  }

  /**
   * Return permission of backend
   *
   * @return mixed
   */
  public function permissions()
  {
    try {
      $permissions = $this->permissions->all();
      $modules = config('asgard.iprofile.config.modules-to-manage-permissions');
      $response = array();

      if (isset($modules)) {
        foreach ($modules as $name){
          $response[$name] = $permissions[$name];
        }
      }

      //Response
      $response = ["data" => $response];
    } catch (\Exception $e) {
      $status = $this->getStatusError($e->getCode());
      $response = ["errors" => $e->getMessage()];
    }

    //Return response
    return response()->json($response, $status ?? 200);
  }

}
