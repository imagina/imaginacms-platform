<?php

namespace Modules\Iprofile\Http\Controllers\Api;

use Exception;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Lcobucci\JWT\Parser;
use Modules\Core\Http\Controllers\BasePublicController;
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;
use Modules\Iprofile\Events\ImpersonateEvent;
use Modules\Iprofile\Repositories\UserApiRepository;
use Modules\User\Exceptions\InvalidOrExpiredResetCode;
use Modules\User\Exceptions\UserNotFoundException;
use Modules\User\Http\Requests\ResetCompleteRequest;
use Modules\User\Http\Requests\ResetRequest;
use Modules\User\Services\UserResetter;
use Socialite;

// Reset

// Socialite
//Controllers

class AuthApiController extends BaseApiController
{
    private $userApiController;
    private $fieldApiController;
    private $user;

    public function __construct(UserApiController $userApiController, FieldApiController $fieldApiController, UserApiRepository $user)
    {
        parent::__construct();
        $this->userApiController = $userApiController;
        $this->fieldApiController = $fieldApiController;
        $this->user = $user;
        $this->clearTokens();//CLear tokens
    }


    /**
     * Login Api Controller
     * @param Request $request
     * @return mixed
     */
    public function login(Request $request)
    {
        try {
            $credentials = [ //Get credentials
                'email' => $request->input('username'),
                'password' => $request->input('password')
            ];

            //Auth attemp and get token
            $token = $this->validateResponseApi($this->authAttempt($credentials));
            $user = $this->validateResponseApi($this->me());//Get user Data

            $response = ["data" => [
                'userToken' => $token->bearer,
                'expiresIn' => $token->expiresDate,
                'userData' => $user->userData
            ]];//Response
        } catch (Exception $e) {
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $this->getErrorMessage($e)];
        }

        //Return response
        return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
    }

    /**
     * Reset Api Controller
     * @param Request $request
     * @return mixed
     */
    public function reset(Request $request)
    {
        try {
            $credentials = [ //Get credentials
                'email' => $request->input('username'),
            ];
            app(UserResetter::class)->startReset($credentials);
            $response = ["data" => ["data" => "Request successful"]];//Response
        } catch (UserNotFoundException $e) {
            $status = $this->getStatusError(404);
            $response = ["errors" => trans('user::messages.no user found')];
        } catch (Exception $e) {
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $e->getMessage()];
        }

        //Return response
        return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
    }

    /**
     * Reset Complete Api Controller
     * @param Request $request
     * @return mixed
     */
    public function resetComplete(Request $request)
    {
        try {
            $credentials = [ //Get credentials
                'password' => $request->input('password'),
                'password_confirmation' => $request->input('passwordConfirmation'),
                'userId' => $request->input('userId'),
                'code' => $request->input('token')
            ];
            $this->validateRequestApi(new ResetCompleteRequest($credentials));
            app(UserResetter::class)->finishReset($credentials);

            $user = $this->user->find($request->input('userId'));

            $response = ["data" => ['email' => $user->email]];//Response

        } catch (UserNotFoundException $e) {
            \Log::error($e->getMessage());
            $status = $this->getStatusError(404);
            $response = ["errors" => trans('user::messages.no user found')];

        } catch (InvalidOrExpiredResetCode $e) {
            $status = $this->getStatusError(402);
            $response = ["errors" => trans('user::messages.invalid reset code')];
        } catch (Exception $e) {
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $e->getMessage()];
        }

        //Return response
        return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
    }


    /**
     * Auth Attempt Api Controller
     * @param $credentials
     * @return mixed
     */
    public function authAttempt($credentials)
    {

        try {
            $credentials = (object)$credentials;


            try {
                //Find email in users fields
                $field = $this->validateResponseApi(
                    $this->fieldApiController->show(
                        json_encode($credentials->email),
                        new Request([
                            'filter' => json_encode(['field' => 'value']),
                            'include' => 'user'
                        ])
                    )
                );

                //If exist email in users fields, change email of credentials
                if (isset($field->user)) $credentials->email = $field->user->email;
            } catch (Exception $e) {
            }

            //Try login
            if (Auth::attempt((array)$credentials)) {
                $user = Auth::user();//Get user
                $token = $this->getToken($user);//Get token

                //Response bearer and expires date
                $response = ["data" => [
                    "bearer" => 'Bearer ' . $token->accessToken,
                    "expiresDate" => $token->token->expires_at,
                ]];
            } else {
                throw new Exception('User or Password invalid', 401);
            }


        } catch (Exception $e) {
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $this->getErrorMessage($e)];
            if ($e->getMessage() === 'Your account has not been activated yet.') $status = 401;
        }

        //Return response
        return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
    }


    /**
     * Me Api Controller
     * @return mixed
     */
    public function me()
    {
        try {
            $user = Auth::user();//Get user loged

            //add: custom user includes from config (slim)
            $customUserIncludes = config('asgard.iprofile.config.customUserIncludes');
            $includes = array_keys($customUserIncludes);

            //Find user with relationships
            $userData = $this->validateResponseApi(
                $this->userApiController->show($user->id, new Request([
                        'include' => 'fields,departments,addresses,settings,roles'.(count($includes)?','.join(',',$includes):'')]
                ))
            );

            //Response
            $response = ["data" => [
                'userData' => $userData
            ]];
        } catch (Exception $e) {
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $this->getErrorMessage($e)];
        }

        //Return response
        return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
    }


    /**
     * Logout Api Controller
     * @param Request $request
     * @return mixed
     */
    public function logout(Request $request)
    {
        try {
            $token = $this->validateResponseApi($this->getRequestToken($request));//Get Token
            DB::table('oauth_access_tokens')->where('id', $token->id)->delete();//Delete Token
        } catch (Exception $e) {
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $e->getMessage()];
        }

        //Return response
        return response()->json($response ?? ["data" => "You have been successfully logged out!"], $status ?? 200);
    }


    /**
     * logout All Sessions Api Controller
     * @param Request $request
     * @return mixed
     */
    public function logoutAllSessions(Request $request)
    {
        try {
            $userId = $request->input('userId');//Get user ID form request
            if (isset($userId)) {
                //Delete all tokens of this user
                DB::table('oauth_access_tokens')->where('user_id', $userId)->delete();
            }
        } catch (Exception $e) {
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $e->getMessage()];
        }

        //Return response
        return response()->json($response ?? ["data" => "You have been successfully logged out!"], $status ?? 200);
    }


    /**
     * Impersonate Api Controller
     * @param Request $request
     * @return mixed
     */
    public function impersonate(Request $request)
    {
        try {
            //Get Token
            $this->validateResponseApi($this->getRequestToken($request));

            $userId = $request->input('userId');//GEt user id impersonator
            $userIdToImpersonate = $request->input('userIdImpersonate');//Get user ID to impersonate

            Auth::loginUsingId($userId);//Loged impersonator
            $params = $this->getParamsRequest($request);//Get params

            //Check permissions of impersonator and settings to impersonate
            if (isset($params->permissions['profile.user.impersonate']) && $params->permissions['profile.user.impersonate']) {
                //Emit event impersonate
                event(new ImpersonateEvent($userIdToImpersonate, $request->ip()));

                Auth::logout();//logout impersonator
                $userImpersonate = Auth::loginUsingId($userIdToImpersonate);//Loged impersonator
                $token = $this->getToken($userImpersonate);//Get Token
                $user = $this->validateResponseApi($this->me());//Get user Data

                //Response
                $response = ["data" => [
                    "userToken" => 'Bearer ' . $token->accessToken,
                    'expiresIn' => $token->token->expires_at,
                    'userData' => $user->userData
                ]];
            } else throw new Exception('Unauthorized', 403);
        } catch (Exception $e) {
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $e->getMessage()];
        }

        //Return response
        return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
    }


    /**
     * Refresh Token Api Controller
     * @param Request $request
     * @return mixed
     */
    public function refreshToken(Request $request)
    {
        try {
            //Get Token
            $token = $this->validateResponseApi($this->getRequestToken($request));
            $expiresIn = now()->addMinutes(1440);

            //Add 15 minutos to token
            DB::table('oauth_access_tokens')->where('id', $token->id)->update([
                'updated_at' => now(),
                'expires_at' => $expiresIn
            ]);

            $response = ['data' => ['expiresIn' => $expiresIn]];
        } catch (Exception $e) {
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $e->getMessage()];
        }

        //Return response
        return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
    }


    /**
     * Social Auth Api Controller incomplete
     * @param Request $request
     * @param $provider
     * @return mixed
     */
    public function getSocialAuth(Request $request, $provider)
    {

        try {

            /*
            if(!empty($request->query('redirect'))) {
              \Session::put('redirect',$request->query('redirect'));
            }
            */

            if (!config("services.$provider"))
                throw new Exception('Error - Config Services {$provider} - Not defined', 204);

            $redirect = Socialite::driver($provider)->stateless()->redirect()->getTargetUrl();

            //Response
            $response = ["data" => [
                'redirect' => $redirect
            ]];

        } catch (Exception $e) {
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $e->getMessage()];

        }

        return response()->json($response, $status ?? 200);

    }

    /**
     * @param null $provider
     */
    public function getSocialAuthCallback($provider = null)
    {
        dd("callback");
    }

    /**
     * @param $request
     * @return mixed
     */
    private function getRequestToken($request)
    {
        try {
            $value = $request->bearerToken();//Get from request
            if ($value) {
                $id = (new Parser())->parse($value)->getHeader('jti');//Decode and get ID
                $token = \DB::table('oauth_access_tokens')->where('id', $id)->first();//Find data Token
                $success = true;//Default state

                //Validate if exist token
                if (!isset($token)) $success = false;

                //Validate if is revoked
                if (isset($token) && (int)$token->revoked >= 1) $success = false;

                //Validate if Token expirated
                if (isset($token) && (strtotime(now()) >= strtotime($token->expires_at))) $success = false;

                //Revoke Token if is invalid
                if (!$success) {
                    if (isset($token)) $token->delete();//Delete token
                    throw new Exception('Unauthorized', 401);//Throw unautorize
                }

                $response = ['data' => $token];//Response Token ID decode
                \DB::commit();//Commit to DataBase
            } else throw new Exception('Unauthorized', 401);//Throw unautorize
        } catch (Exception $e) {
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $e->getMessage()];
        }

        //Return response
        return response()->json($response, $status ?? 200);
    }


    /**
     * Provate method Clear Tokens
     */
    private function clearTokens()
    {
        //Delete all tokens expirateds or revoked
        DB::table('oauth_access_tokens')->where('expires_at', '<=', now())
            ->orWhere('revoked', 1)
            ->delete();
    }


    /**
     * @param $user
     * @return bool
     */
    private function getToken($user)
    {
        if (isset($user))
            return $user->createToken('Laravel Password Grant Client');
        else return false;
    }
}
