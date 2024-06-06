<?php

namespace Modules\Ihelpers\Http\Controllers\Api;

use Modules\Core\Http\Controllers\BasePublicController;
use Modules\Ihelpers\Http\Controllers\Api\PermissionsApiController;
use Modules\Ihelpers\Http\Controllers\Api\SettingsApiController;
use Mockery\CountValidator\Exception;
use Illuminate\Support\Facades\Auth;
use Modules\Iprofile\Entities\Role;
use Validator;

class BaseApiController extends BasePublicController
{
  private $permissions;
  private $settingsController;
  private $permissionsController;
  private $user;

  public function __construct()
  {
  }

  //Return params from Request
  public function getParamsRequest($request, $params = [])
  {
    $defaultValues = (object)$params;//Convert to object the params
    $this->settingsController = new SettingsApiController();
    $this->permissionsController = new PermissionsApiController();

    //Set default values
    $default = (object)[
      "page" => $defaultValues->page ?? false,
      "take" => $defaultValues->take ?? false,
      "filter" => $defaultValues->filter ?? [],
      'include' => $defaultValues->include ?? [],
      'fields' => $defaultValues->fields ?? []
    ];

    // set current auth user
    $this->user = Auth::user();
    $setting = $request->input('setting') ? (is_string($request->input('setting')) ? json_decode($request->input('setting')) : (is_array($request->input('setting')) ? json_decode(json_encode($request->input('setting'))) : $request->input('setting'))) : false;

    $departments = $this->user ? $this->user->departments()->get() : false;//Department data
    $roles = $this->user ? $this->user->roles()->get() : false;//Role data
    $department = ($departments && $setting && isset($setting->departmentId)) ?
      $departments->where("id", $setting->departmentId)->first() : false;
    $role = ($roles && $setting && isset($setting->roleId)) ? $roles->where("id", $setting->roleId)->first() : false;

    //Return params
    $params = (object)[
      "page" => is_numeric($request->input('page')) ? $request->input('page') : $default->page,
      "take" => is_numeric($request->input('take')) ? $request->input('take') :
        ($request->input('page') ? 12 : $default->take),
      "filter" => json_decode($request->input('filter')) ?? (object)$default->filter,
      "include" => $request->input('include') ? explode(",", $request->input('include')) : $default->include,
      "fields" => $request->input('fields') ? explode(",", $request->input('fields')) : $default->fields,
      'department' => $department,
      'departments' => $departments,
      'role' => $role,
      'roles' => $roles,
      'setting' => $setting,//Role and department selected
      'settings' => $this->user ? $this->settingsController->getAll([
        "userId" => $this->user->id,
        "roleId" => $role->id ?? false,
        "departmentId" => $department->id ?? false]) : [],
      'permissions' => $this->user ? $this->permissionsController->getAll([
        "userId" => $this->user->id,
        "roleId" => $role->id ?? false,
      ]) : [],
      "user" => $this->user
    ];

    //Set language translation
    if (isset($setting->locale) && !is_null($setting->locale)) {
      \App::setLocale($setting->locale);
    }

    //Set language translation by filter
    if (isset($params->filter->locale) && !is_null($params->filter->locale)) {
      \App::setLocale($params->filter->locale);
    }

    //Set locale to filter
    $params->filter->locale = \App::getLocale();
    return $params;//Response
  }

  //Validate if response Api is successful
  public function validateResponseApi($response)
  {
    //Get response
    $data = json_decode($response->content());

    //If there is errors, throw error
    if (isset($data->errors))
      throw new \Exception($data->errors, $response->getStatusCode());
    else {//if response is successful, return response
      return $data->data;
    }
  }

  //Validate if fields are validated according to rules
  public function validateRequestApi($request)
  {
    $request->setContainer(app());
    if(method_exists($request, "getValidator"))
      $validator = $request->getValidator();
    else
      $validator = Validator::make($request->all(), $request->rules(),$request->messages());
  
    //if get errors, throw errors
    if ($validator->fails()) {
      $errors = json_decode($validator->errors());
      throw new \Exception(json_encode($errors), 400);
    } else {//if vlaidation is sucessful, return true
      return true;
    }
  }

  //Validate if user has permission
  public function validatePermission($request, $permissionName)
  {
    //Get permissions
    $this->permissionsController = new PermissionsApiController();
    $permissions = $this->permissionsController->getAll($request);

    //Validate permissions
    if ($permissions && !isset($permissions[$permissionName]))
      throw new \Exception('Permission Denied', 403);
  }

  //Validate if code is like status response, and return status code
  public function getStatusError($code = false)
  {
    switch ($code) {
      case 204:
        return 204;
        break;
      case 400: //Bad Request
        return 400;
        break;
      case 401:
        return 401;
        break;
      case 403:
        return 403;
        break;
      case 404:
        return 404;
        break;
      case 502:
        return 502;
        break;
      case 504:
        return 504;
        break;
      default:
        return 500;
        break;
    }
  }

  //Get users from department
  public function getUsersByDepartment($params, $pluck = 'id')
  {
    $department = $params->department;//Get Department
    $exceptionRole = [1];//Exclude users from role "admin"
    $response = [];//Data response

    if (isset($department) && !empty($department)) {
      if (isset($params->permissions['profile.user.index-by-department'])) {
        $response = $department->users()
          ->whereNotIn('users.id', function ($query) use ($exceptionRole) {
            $query->select('user_id')->from('role_users')->whereIn('role_id', $exceptionRole);
          })->get()->pluck($pluck)->toArray();

        if ($department->children) {
          foreach ($department->children as $subDepartment) {
            $usersDepartment = $subDepartment->users()
              ->whereNotIn('users.id', function ($query) use ($exceptionRole) {
                $query->select('user_id')->from('role_users')->whereIn('role_id', $exceptionRole);
              })->get()->pluck($pluck)->toArray();

            $response = array_merge($response, $usersDepartment);
          }
        }
      } else //if not has permission, return just id of user loged
        $response = array_merge($response, [$params->user->id]);
    }

    return $response;//Response
  }

  //Transform data of Paginate
  public function pageTransformer($data)
  {
    return [
      "total" => $data->total(),
      "lastPage" => $data->lastPage(),
      "perPage" => $data->perPage(),
      "currentPage" => $data->currentPage()
    ];
  }

  //Generate password
  public function generatePassword($length = 12, $add_dashes = false, $available_sets = 'luds')
  {
    $sets = array();
    if (strpos($available_sets, 'l') !== false)
      $sets[] = 'abcdefghjkmnpqrstuvwxyz';
    if (strpos($available_sets, 'u') !== false)
      $sets[] = 'ABCDEFGHJKMNPQRSTUVWXYZ';
    if (strpos($available_sets, 'd') !== false)
      $sets[] = '23456789';
    if (strpos($available_sets, 's') !== false)
      $sets[] = '!@#$%&*?/_-+';
    $all = '';
    $password = '';
    foreach ($sets as $set) {
      $password .= $set[array_rand(str_split($set))];
      $all .= $set;
    }
    $all = str_split($all);
    for ($i = 0; $i < $length - count($sets); $i++)
      $password .= $all[array_rand($all)];
    $password = str_shuffle($password);
    if (!$add_dashes)
      return $password;
    $dash_len = floor(sqrt($length));
    $dash_str = '';
    while (strlen($password) > $dash_len) {
      $dash_str .= substr($password, 0, $dash_len) . '-';
      $password = substr($password, $dash_len);
    }
    $dash_str .= $password;
    return $dash_str;
  }
}
