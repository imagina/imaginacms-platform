<?php

namespace Modules\Iprofile\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;

class SettingMiddleware extends BaseApiController
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */


    public function __construct()
    {
    }


    public function handle(Request $request, Closure $next, $settings)
    {
        try {

            //Get data
            $data = (object)$request->input('attributes');

            //Get Parameters from URL.
            $params = $this->getParamsRequest($request);

            $user = $params->user;
            //convert settings into array
            $settings = explode('.', $settings);

            foreach ($settings as $setting) {
                // if the user has settings then go to check
                if (isset($params->settings[$setting]) && !empty($params->settings[$setting])) {

                    // if not has setting value assigned
                    if(!$this->hasSettingValue($params->settings[$setting], $setting, $data)){
                        $response = ["errors" => 'Unauthorized.'];
                        return response($response, Response::HTTP_UNAUTHORIZED);
                    }
                }
            }

        } catch (\Exception $error) {

            $response = ["errors" => 'Bad Request'];
            return response($response, Response::HTTP_BAD_REQUEST);
        }
        return $next($request);

    }

    private function hasSettingValue($userSetting,$setting, $data){
        $dataToCheck = [];

        // add here the case with setting name and then set to $dataToCheck the field from data
        switch($setting){
            case 'assignedRoles':
                $dataToCheck = $data->roles;
                break;
            case 'assignedDepartments':
                $dataToCheck = $data->departments;
                break;
        }
        $result = array_diff($dataToCheck,$userSetting);


        if(count($result))
            return false;
        else
            return true;
    }
}