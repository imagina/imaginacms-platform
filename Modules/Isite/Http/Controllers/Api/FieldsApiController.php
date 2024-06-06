<?php

namespace Modules\Isite\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;
use Nwidart\Modules\Module;

class FieldsApiController extends BaseApiController
{
  private $module;

  public function __construct()
  {
    $this->module = app('modules');
  }

  //Return fields
  public function index(Request $request)
  {
    try {
      $params = $this->getParamsRequest($request);//Get Parameters from URL.
      $enabledModules = $this->module->allEnabled();//Get all modules
      $response = ['settings-fields' => [], 'crud-fields' => []];//Default response

      //Get configs from modules
      foreach ($enabledModules as $moduleName => $module) {
        foreach ($response as $fileName => $item) {
          $configData = config("asgard.{$module->getLowerName()}.{$fileName}");

          //Add config data to response
          if ($configData) $response[$fileName][$moduleName] = $this->translateLabels($configData);
        }
      }

      //Validate filter name
      if (isset($params->filter->configFieldName)) {
        $fieldName = explode('.', $params->filter->configFieldName);
        if ($fieldName && !empty($fileName)) {
          foreach ($fieldName as $name)
            if (isset($response[$name])) $response = $response[$name];
            else $response = null;
        }
      }

      //Response data
      $response = ["data" => $response];
    } catch (\Exception $e) {
      $status = $this->getStatusError($e->getCode());
      $response = ["errors" => $e->getMessage()];
    }

    //Return response
    return response()->json($response, $status ?? 200);
  }

  //Recursive Translate labels
  public function translateLabels($data)
  {
    foreach ($data as $key => &$item) {
      if (is_string($item)) $item = trans($item);
      else if (is_array($item)) {
        $item = $this->translateLabels($item);
      }
    }

    return $data;
  }
}
