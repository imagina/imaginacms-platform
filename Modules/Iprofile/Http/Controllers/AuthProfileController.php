<?php

namespace Modules\Iprofile\Http\Controllers;

use Cartalyst\Sentinel\Laravel\Facades\Reminder;
use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\MessageBag;

use Modules\Core\Http\Controllers\BasePublicController;

use Modules\User\Events\UserHasRegistered;
use Modules\User\Events\UserLoggedIn;
use Modules\User\Http\Requests\LoginRequest;
use Modules\User\Http\Requests\RegisterRequest;
use Modules\User\Http\Requests\ResetCompleteRequest;
use Modules\User\Http\Requests\ResetRequest;
use Modules\User\Http\Controllers\AuthController;
use Modules\User\Repositories\RoleRepository;
use Modules\User\Repositories\UserRepository;
use Modules\User\Entities\Sentinel\User;
use Modules\Setting\Contracts\Setting;
use Lcobucci\JWT\Parser;
use Validator;

use Socialite;
use Laravel\Socialite\Contracts\User as ProviderUser;

use Modules\Iprofile\Http\Controllers\Api\FieldApiController;

use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;

use Modules\Iprofile\Entities\ProviderAccount;

//use Modules\Iprofile\Http\Requests\LoginRequestProfile;
//use Modules\Iprofile\Entities\UserField;

class AuthProfileController extends AuthController
{
    private $user;

    private $role;

    private $errors;

    private $field;

    private $baseApi;

    private $providerAccount;

    private $setting;

    public function __construct(
    MessageBag $errors,
    UserRepository $user,
    RoleRepository $role,
    FieldApiController $field,
    BaseApiController $baseApi,
    ProviderAccount $providerAccount,
    Setting $setting
  ) {
        parent::__construct();
        $this->user = $user;
        $this->role = $role;
        $this->errors = $errors;
        $this->field = $field;
        $this->baseApi = $baseApi;
        $this->providerAccount = $providerAccount;
        $this->setting = $setting;
    }

    /**
     * GET LOGIN
     */
    public function getLogin()
    {
        $tpl = 'iprofile::frontend.login';
        $ttpl = 'iprofile.login';

        request()->session()->put('url.intended', url()->previous());

    $panel = config("asgard.iprofile.config.panel");

    if(!empty($panel) && $panel == "quasar"){

        return redirect("/ipanel/#/auth/login"."?redirectTo=".url()->previous());
      
        }

        return view($tpl);
    }

    /**
     * POST LOGIN
     */
    public function postLogin(LoginRequest $request)
    {
        $data = $request->all();

        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        $remember = (bool) $request->get('remember_me', false);
        $error = $this->auth->login($credentials, $remember);

        if ($error) {
            return redirect()->back()->withInput()->withError($error);
        }

        $user = $this->auth->user();
        event(new UserLoggedIn($user));

        if (isset($data['embedded']) && $data['embedded']) {
            return redirect(tenant_route(request()->getHost(), $data['embedded']))
                ->withSuccess(trans('user::messages.successfully logged in'));
        } elseif (! empty(request()->session()->get('url.intended'))) {
            $url = request()->session()->get('url.intended');
            request()->session()->put('url.intended', null);

            return redirect()->to($url)
                ->withSuccess(trans('user::messages.successfully logged in'));
        } elseif (! empty($request->headers->get('referer'))) {
            return redirect()->to($request->headers->get('referer'))
                ->withSuccess(trans('user::messages.successfully logged in'));
        }

        return redirect()->intended(route(config('asgard.user.config.redirect_route_after_login')))
            ->withSuccess(trans('user::messages.successfully logged in'));
    }

    /**
     * GET LOGOUT
     */
    public function getLogout()
    {
        \DB::table('oauth_access_tokens')->where('user_id', \Auth::id() ?? null)->delete(); //Delete Token
        $this->auth->logout();

        return \Redirect::to('/');
    }

    /**
     * GET REGISTER
     */
    public function getRegister()
    {
        $usersCanRegisterSetting = setting('iprofile::registerUsers', null, true);

        if ($usersCanRegisterSetting) {
            parent::getRegister();

            $panel = config('asgard.iprofile.config.panel');

            if ($panel == 'quasar') {
                return redirect('/ipanel/#/auth/login'.'?redirectTo='.url()->previous());
            }

            $tpl = 'iprofile::frontend.register';
            $ttpl = 'iprofile.register';
            if (view()->exists($ttpl)) {
                $tpl = $ttpl;
            }

            return view($tpl);
        } else {
            return abort(404);
        }
    }

    /**
     * POST REGISTER
     */
    public function userRegister(RegisterRequest $request)
    {
        \DB::beginTransaction();

        try {
            $usersCanRegisterSetting = setting('iprofile::registerUsers', null, true);

            if ($usersCanRegisterSetting) {
                $data = $request->all();

                $validateRegisterWithEmail = setting('iprofile::validateRegisterWithEmail', null, false);

                // Check Exist Roles
                if (isset($data['roles'])) {
                    $roles = $data['roles'];
                    $newRoles = [];

                    foreach ($roles as $rolName) {
                        $roleCustomer = $this->role->findByName($rolName);
                        if ($roleCustomer) {
                            array_push($newRoles, $roleCustomer->id);
                        }
                    }

                    $data['roles'] = [];

                    if (count($newRoles) > 0) {
                        $data['roles'] = $newRoles;
                    } else {
                        $roleCustomer = $this->role->findByName('User');
                        array_push($data['roles'], $roleCustomer->id);
                    }
                } else {
                    $data['roles'] = [];
                    $roleCustomer = $this->role->findByName('User');
                    array_push($data['roles'], $roleCustomer->id);
                }

                if (! isset($data['is_activated']) && ! $validateRegisterWithEmail) {
                    $data['is_activated'] = 1;
                } elseif ($validateRegisterWithEmail) {
                    $data['is_activated'] = 0;
                }

                // Create User with Roles
                $user = $this->user->createWithRoles($data, $data['roles'], $data['is_activated']);
                $checkPointRegister = $this->setting->get('iredeems::points-per-register-user-checkbox');
                if ($checkPointRegister) {
                    //Assign points to user
                    $pointsPerRegister = $this->setting->get('iredeems::points-per-register-user');
                    if ((int) $pointsPerRegister > 0) {
                        iredeems_StorePointUser([
                            'user_id' => $user->id,
                            'pointable_id' => 0,
                            'pointable_type' => '---',
                            'type' => 1,
                            'description' => trans('iredeems::common.settingsMsg.points-per-register'),
                            'points' => (int) $pointsPerRegister,
                        ]);
                    }//points to assign > 0
                }//Checkpoint per register
        //Extra Fields
                if (isset($data['fields'])) {
                    $field = [];
                    foreach ($data['fields'] as $key => $value) {
                        $field['user_id'] = $user->id; // Add user Id
                        $field['value'] = $value;
                        $field['name'] = $key;

                        /*
                        $this->validateResponseApi(
                            $this->field->create(new Request(['attributes' => (array)$field]))
                        );
                        */
                        $this->field->create(new Request(['attributes' => (array) $field]));
                    }
                }

                if ($validateRegisterWithEmail) {
                    event(new UserHasRegistered($user));
                }

                \DB::commit(); //Commit to Data Base
            } else {
                abort(401);
            }
        } catch (\Throwable $t) {
            \DB::rollback(); //Rollback to Data Base

            $response['status'] = 'error';
            $response['message'] = $t->getMessage();
            \Log::error($t);

            echo $t->getMessage();
            exit();

            return redirect(tenant_route(request()->getHost(), $data['embedded'] ?? 'account.profile.index'))
              ->withError($response['message']);
        }

        if ($data['is_activated'] == 0) {
            $msj = trans('user::messages.account created check email for activation');
        } else {
            $msj = trans('iprofile::frontend.messages.account created');
            $user = \Sentinel::findById($user->id);
            $autn = \Sentinel::login($user);
        }

        return redirect(tenant_route(request()->getHost(), $data['embedded'] ?? 'account.register'))
          ->withSuccess($msj);
    }

    /**
     * GET ACTIVATE
     */
    public function getActivate($userId, $code)
    {
        if ($this->auth->activate($userId, $code)) {
            return redirect()->route('account.login')
              ->withSuccess(trans('user::messages.account activated you can now login'));
        }

        return redirect()->route('account.register')
          ->withError(trans('user::messages.there was an error with the activation'));
    }

    /**
     * GET RESET
     */
    public function getReset()
    {
        $tpl = 'iprofile::frontend.reset.begin';
        $ttpl = 'iprofile.reset.begin';
        if (view()->exists($ttpl)) {
            $tpl = $ttpl;
        }

        return view($tpl);
    }

    /**
     * POST RESET
     */
    public function postReset(ResetRequest $request)
    {
        $user = $this->user->findByCredentials($request->all());
        if ($user) {
            $reminder = Reminder::exists($user);
            if ($reminder == false) {
                parent::postReset($request);
            }
        }

        return redirect()->route('account.reset')
          ->withSuccess(trans('user::messages.check email to reset password'));
    }

    /**
     * GET RESET COMPLETE
     */
    public function getResetComplete()
    {
        $tpl = 'iprofile::frontend.reset.complete';
        $ttpl = 'iprofile.reset.complete';
        if (view()->exists($ttpl)) {
            $tpl = $ttpl;
        }

        return view($tpl);
    }

    /**
     * POST RESET COMPLETE
     */
    public function postResetComplete($userId, $code, ResetCompleteRequest $request)
    {
        parent::postResetComplete($userId, $code, $request);

        return redirect()->route('account.login')
          ->withSuccess(trans('user::messages.password reset'));
    }

    /**
     * GET SOCIAL
     */
    public function getSocialAuth($provider, Request $request)
    {
        try {
            if (! setting('iprofile::registerUsersWithSocialNetworks')) {
                throw new Exception('Users can\'t login with social networks', 401);
            }

            if (! empty($request->query('redirect'))) {
                \Session::put('redirect', $request->query('redirect'));
            }

            if (! config("services.$provider")) {
                throw new Exception("Error - Config Services {$provider} - Not defined", 404);
            }
        } catch (\Exception $e) {
            $status = $e->getCode();
            $response = ['errors' => $e->getMessage()];
        }

        return Socialite::driver($provider)->redirect();
    }

    /**
     * GET SOCIAL
     */
    public function getSocialAuthCallback($provider = null)
    {
        if (! config("services.$provider")) {
            return abort('404');
        } else {
            $fields = [];

            $redirect = \Session::get('redirect', '');
            \Session::put('redirect', '');

            if ($provider == 'facebook') {
                $fields = ['first_name', 'last_name', 'picture.width(1920).redirect(false)', 'email', 'gender', 'birthday', 'address', 'about', 'link'];
            }

            try {
                if (! setting('iprofile::registerUsersWithSocialNetworks')) {
                    throw new \Exception('Users can\'t login with social networks', 401);
                }

                $user = $this->_createOrGetUser($provider, $fields);

                if (isset($user->id)) {
                    $autn = \Sentinel::login($user);

                    if (! empty($redirect)) {
                        return redirect($redirect);
                    }

                    return redirect()->route('account.profile.index')
                      ->withSuccess(trans('iprofile::messages.account created'));
                } else {
                    throw new \Exception('Users can\'t login with social networks', 401);
                }
            } catch (\Exception $e) {
                $status = $e->getCode();
                $response = ['errors' => $e->getMessage()];

                return redirect()->route('account.register')
                  ->withError($e->getMessage());
            }
        }
    }

    /**
     * GET SOCIAL
     */
    public function _createOrGetUser($provider, $fields = [])
    {
        if ($provider == 'facebook') {
            $providerUser = Socialite::driver($provider)->stateless(true)->fields($fields)->user();
        } else {
            $providerUser = Socialite::driver($provider)->stateless(true)->user();
        }

        $provideraccount = $this->providerAccount->whereProvider($provider)->whereProviderUserId($providerUser->getId())
          ->first();

        //If user for this social login exists update short token and return the user associated
        if (isset($provideraccount->user)) {
            $updateoptions = $provideraccount->options;
            $updateoptions['short_token'] = $providerUser->token;
            $provideraccount->options = $updateoptions;
            $provideraccount->save();

            return $provideraccount->user;

        //New social login or user
        } else {
            $strPwd = rand();
            $userdata['email'] = $providerUser->getEmail();
            $userdata['password'] = md5($strPwd);

            if ($provider == 'facebook') {
                //$social_picture = $providerUser->user['picture']['data'];
                $userdata['first_name'] = $providerUser->user['first_name'];
                $userdata['last_name'] = $providerUser->user['last_name'];
                $userdata['is_activated'] = true;
            } else {
                $fullname = explode(' ', $providerUser->getName());
                $userdata['first_name'] = $fullname[0];
                $userdata['last_name'] = $fullname[1];
                $userdata['is_activated'] = true;
            }
            //validating if the userData contain the email
            if (empty($userdata['email'])) {
                throw new \Exception(trans('iprofile::frontend.messages.providerEmailEmpty', ['providerName' => $provider]), 400);
            }

            //Let's create the User
            $role = $this->role->findByName(config('asgard.user.config.default_role', 'User'));
            $existUser = false;
            $user = User::where('email', $userdata['email'])->first();

            if (! $user) {
                if ($userdata['is_activated']) {
                    $user = $this->user->createWithRoles($userdata, [$role->id], $userdata['is_activated'] ?? false);
                }
            } else {
                $existUser = true;
            }

            if (isset($user->email) && ! empty($user->email)) {
                $createSocial = true;
                if ($existUser) {
                    $providerData = ProviderAccount::where('user_id', $user->id)->first();
                    if ($providerData) {
                        $createSocial = false;
                    }
                }
                if ($createSocial) {
                    //Let's associate the Social Login with this user
                    $provideraccount = new ProviderAccount();
                    $provideraccount->provider_user_id = $providerUser->getId();
                    $provideraccount->user_id = $user->id;
                    $provideraccount->provider = $provider;
                    $provideraccount->options = ['short_token' => $providerUser->token];
                    $provideraccount->save();

                    //Let's create the Profile for this user

                    $social_picture = $providerUser->getAvatar();

                    $b64image = 'data:image/jpg;base64,'.base64_encode(file_get_contents($social_picture));
                    $field['user_id'] = $user->id; // Add user Id
                    $field['value'] = $b64image;
                    $field['name'] = 'mainImage';
                    $this->field->create(new Request(['attributes' => (array) $field]));
                }
            } else {
                return null;
            }

            return $user;
        }
    }
}
