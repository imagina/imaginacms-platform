<?php

namespace Modules\Iprofile\Http\Controllers\Api;

use Carbon\Carbon;
use Cartalyst\Sentinel\Laravel\Facades\Activation;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;
use Modules\Iprofile\Entities\Setting as profileSetting;
use Modules\Iprofile\Entities\UserPasswordHistory;
use Modules\Iprofile\Events\UserCreatedEvent;
use Modules\Iprofile\Events\UserUpdatedEvent;
use Modules\Iprofile\Http\Requests\CreateUserApiRequest;
use Modules\Iprofile\Http\Requests\UpdatePasswordRequest;
use Modules\Iprofile\Http\Requests\UpdateUserApiRequest;
use Modules\Iprofile\Repositories\FieldRepository;
use Modules\Iprofile\Repositories\UserApiRepository;
use Modules\Iprofile\Transformers\UserTransformer;
//Events
use Modules\Setting\Contracts\Setting;
use Modules\User\Http\Requests\RegisterRequest;
use Modules\User\Repositories\UserRepository;
use Modules\User\Services\UserRegistration;

class UserApiController extends BaseApiController
{
    private $user;

    private $field;

    private $repoField;

    private $address;

    private $setting;

    private $userRepository;

    private $fhaOld;

    private $settingAsgard;

    private $profileSetting;

    private $userPasswordHistoryService;

    private $userService;

    public function __construct(
    UserApiRepository $user,
    FieldApiController $field,
    FieldRepository $repoField,
    AddressApiController $address,
    SettingApiController $setting,
    Setting $settingAsgard,
    UserRepository $userRepository,
    profileSetting $profileSetting)
    {
        parent::__construct();
        $this->user = $user;
        $this->field = $field;
        $this->repoField = $repoField;
        $this->address = $address;
        $this->setting = $setting;
        $this->userRepository = $userRepository;
        $this->settingAsgard = $settingAsgard;
        $this->profileSetting = $profileSetting;
        $this->userPasswordHistoryService = app("Modules\Iprofile\Services\UserPasswordHistoryService");
        $this->userService = app("Modules\Iprofile\Services\UserService");
    }

    /**
     * GET ITEMS
     *
     * @return mixed
     */
    public function index(Request $request)
    {
        try {
            //Validate permissions
            $this->validatePermission($request, 'profile.user.index');

            //Get Parameters from URL.
            $params = $this->getParamsRequest($request);

            //Add Id of users by department
            if (isset($params->filter->getUsersByDepartment)) {
                $params->usersByDepartment = $this->getUsersByDepartment($params);
            }

            //Request to Repository
            $users = $this->user->getItemsBy($params);

            //Response
            $response = ['data' => UserTransformer::collection($users)];

            //If request pagination add meta-page
            $params->page ? $response['meta'] = ['page' => $this->pageTransformer($users)] : false;
        } catch (\Exception $e) {
            $status = $this->getStatusError($e->getCode());
            $response = ['errors' => $e->getMessage()];
        }

        //Return response
        return response()->json($response, $status ?? 200);
    }

    /**
     * GET A ITEM
     *
     * @return mixed
     */
    public function show($criteria, Request $request)
    {
        try {
            //Get Parameters from URL.
            $params = $this->getParamsRequest($request);

            //Request to Repository
            $user = $this->user->getItem($criteria, $params);

            //Break if no found item
            if (! $user) {
                throw new \Exception('Item not found', 400);
            }

            //Response
            $response = ['data' => new UserTransformer($user)];

            //If request pagination add meta-page
            $params->page ? $response['meta'] = ['page' => $this->pageTransformer($user)] : false;
        } catch (\Exception $e) {
            $status = $this->getStatusError($e->getCode());
            $response = ['errors' => $this->getErrorMessage($e)];
        }

        //Return response
        return response()->json($response, $status ?? 200);
    }

    /**
     * Register users just default department and role
     *
     * @return mixed
     */
    public function register(Request $request)
    {
        //\Log::info("Iprofile:: UserApiController|Register");

        try {
            $data = (object) $request->input('attributes'); //Get data from request

            $filter = []; //define filters
            $validateEmail = $this->settingAsgard->get('iprofile::validateRegisterWithEmail');

            //TODO: validate register for admin > slim
            $adminNeedsToActivateNewUsers = $this->settingAsgard->get('iprofile::adminNeedsToActivateNewUsers');

            $userRepository = app('Modules\Iprofile\Repositories\UserApiRepository');
            $user = $userRepository->getItemsBy()->where('email', $data->email)->first();

            if (isset($user) && $user->is_guest) {
                $data->is_guest = 0;
                $response = $userRepository->updateBy($user->id, $data);
            } else {
                //Validate custom Request user
                $this->validateRequestApi(new CreateUserApiRequest((array) $data));
                // registerExtraFields
                $registerExtraFieldsSetting = json_decode(setting('iprofile::registerExtraFields', null, '[]'));

                if (isset($data->fields)) {
                    foreach ($data->fields as $name => $value) {
                        $fields[] = [
                            'name' => $name,
                            'value' => $value,
                        ];
                    }
                }

        //Checking Role if exist in the setting rolesToRegister
                $rolesToRegister = json_decode(setting('iprofile::rolesToRegister', null, '[2]')); //Default role is USER, ID 2
                if (isset($data->role_id) && in_array($data->role_id, $rolesToRegister)) {
                    $role = is_array($data->role_id) ? $data->role_id : [$data->role_id];
                }

                $attributes = array_merge($request->input('attributes'), [
                    'first_name' => $data->first_name ?? '',
                    'last_name' => $data->last_name ?? '',
                    'email' => $data->email,
                    'password' => $data->password,
                    'password_confirmation' => $data->password_confirmation,
                    'departments' => [1], //Default department is USERS, ID 1
                    'roles' => $role ?? [2], //Default role is USER, ID 2
                    'fields' => $fields ?? [],
                    'is_activated' => (int) $validateEmail ? false : true,
                ]);
                //Format dat ot create user
                $params = [
                    'attributes' => $attributes,
                    'filter' => json_encode([
                        'checkEmail' => (int) $validateEmail ? 1 : 0,
                        'checkAdminActivate' => (int) $adminNeedsToActivateNewUsers ? 1 : 0,
                    ]),
                ];

                //Create user
                $user = $this->validateResponseApi($this->create(new Request($params)));

                //Response and especific if user required check email
                $response = ['data' => ['checkEmail' => (int) $validateEmail ? true : false]];
            }
        } catch (\Exception $e) {
            \Log::error('Iprofile:: UserApiController|Register: '.$e->getMessage());
      //dd($e);
            \DB::rollback(); //Rollback to Data Base
            $status = $this->getStatusError($e->getCode());
            $response = ['errors' => $e->getMessage()];
        }

        //Return response
        return response()->json($response ?? ['data' => 'Request successful'], $status ?? 200);
    }

    /**
     * CREATE A ITEM
     *
     * @return mixed
     */
    public function create(Request $request)
    {
        //\Log::info("Iprofile: UserApiController|Create");

        \DB::beginTransaction();
        try {
            //Validate permissions
            $this->validatePermission($request, 'profile.user.create');

            //Get data
            $data = $request->input('attributes');

            //Get setting from request
            $requestSetting = json_decode($request->input('setting'));
            //\Log::info("Iprofile: UserApiController|Create|RequestSetting: ".$request->input('setting'));

            $data['email'] = strtolower($data['email']); //Parse email to lowercase
            $params = $this->getParamsRequest($request);
            $checkEmail = isset($params->filter->checkEmail) ? $params->filter->checkEmail : false;
            $checkAdminActivate = isset($params->filter->checkAdminActivate) ? $params->filter->checkAdminActivate : false; //TODO: check if admin needs to activate new users > slim

      //$this->validateRequestApi(new RegisterRequest ($data));//Validate Request User
            $this->validateRequestApi(new CreateUserApiRequest($data)); //Validate custom Request user

            if ($checkEmail) { //Create user required validate email
                $user = app(UserRegistration::class)->register($data);
            } else { //Create user activated
                $user = $this->userRepository->createWithRoles($data, $data['roles'], $data['is_activated']);
            }

            if ($checkAdminActivate) {
                $this->update($user->id, new Request(
                    ['attributes' => [
                        'id' => $user->id,
                        'is_activated' => false,
                    ]]
                ));
            }

            // sync tables
            if (isset($data['departments']) && count($data['departments'])) {
                $user->departments()->sync(Arr::get($data, 'departments', []));
            }

            //Create fields
            if (isset($data['fields'])) {
                foreach ($data['fields'] as $field) {
                    $field['user_id'] = $user->id; // Add user Id
                    $this->validateResponseApi(
                        $this->field->create(new Request(['attributes' => (array) $field]))
                    );
                }
            }

            //Create Addresses
            if (isset($data['addresses'])) {
                foreach ($data['addresses'] as $address) {
                    $address['user_id'] = $user->id; // Add user Id
                    $this->validateResponseApi(
                        $this->address->create(new Request(['attributes' => (array) $address]))
                    );
                }
            }

            //Create Settings
            if (isset($data['settings'])) {
                foreach ($data['settings'] as $settingName => $setting) {
                    $this->validateResponseApi(
                        $this->setting->create(new Request(['attributes' => ['related_id' => $user->id, 'entity_name' => 'user', 'name' => $settingName, 'value' => $setting],
                        ]))
                    );
                }
            }

            //Add value from admin
            if (isset($requestSetting->fromAdmin)) {
                $data['fromAdmin'] = $requestSetting->fromAdmin;
            }

            $response = ['data' => 'User Created'];

            //dispatch Event
            event(new UserCreatedEvent($user, $data));

            \DB::commit(); //Commit to Data Base
        } catch (\Exception $e) {
            \DB::rollback(); //Rollback to Data Base
            $status = $this->getStatusError($e->getCode());
            $response = ['errors' => $e->getMessage()];
        }

        //Return response
        return response()->json($response, $status ?? 200);
    }

    /**
     * UPDATE ITEM
     *
     * @return mixed
     */
    public function update($criteria, Request $request)
    {
        //\Log::info("Iprofile: UserApiController|Update");

        \DB::beginTransaction(); //DB Transaction
        try {
            //Validate permissions
            $this->validatePermission($request, 'profile.user.edit');
            $data = $request->input('attributes'); //Get data

            //Get setting from request
            $requestSetting = json_decode($request->input('setting'));

            $params = $this->getParamsRequest($request); //Get Params

            //Validate Request
            $this->validateRequestApi(new UpdateUserApiRequest((array) $data));

            if (isset($data['email'])) {
                $data['email'] = strtolower($data['email']);
                $user = $this->user->findByAttributes(['email' => $data['email']]);
            }

            if (! isset($user) || ! $user || ($user->id == $data['id'])) {
                $user = $this->user->findByAttributes(['id' => $data['id']]);
                $oldData = $user->toArray();

                // configuting activate data to audit
                if (Activation::completed($user) && ! $data['is_activated']) {
                    $oldData['is_activated'] = 1;
                }
                if (! Activation::completed($user) && $data['is_activated']) {
                    $oldData['is_activated'] = 0;
                }

                // actually user roles
                $userRolesIds = $user->roles()->get()->pluck('id')->toArray();
                $this->userRepository->updateAndSyncRoles($data['id'], $data, []);
                $user = $this->user->findByAttributes(['id' => $data['id']]);

                // saving old passrond
                if (isset($data['password'])) {
                    $oldData['password'] = $user->password;
                }

                if (isset($data['roles'])) {
                    // check roles to Attach and Detach
                    $rolesToAttach = array_diff(array_values($data['roles']), $userRolesIds);
                    $rolesToDetach = array_diff($userRolesIds, array_values($data['roles']));

                    // sync roles
                    if (! empty($rolesToAttach)) {
                        $user->roles()->attach($rolesToAttach);
                    }
                    if (! empty($rolesToDetach)) {
                        $user->roles()->detach($rolesToDetach);
                    }
                }

                if (isset($data['departments'])) {
                    // actually user departments
                    $userDepartmentsIds = $user->departments()->get()->pluck('id')->toArray();

                    // check departments to Attach and Detach
                    $departmentsToAttach = array_diff(array_values($data['departments']), $userDepartmentsIds);
                    $departmentsToDetach = array_diff($userDepartmentsIds, array_values($data['departments']));

                    // sync departments
                    if (! empty($departmentsToAttach)) {
                        $user->departments()->attach($departmentsToAttach);
                    }
                    if (! empty($departmentsToDetach)) {
                        $user->departments()->detach($departmentsToDetach);
                    }
                }

                //Create or Update fields
                if (isset($data['fields'])) {
                    foreach ($data['fields'] as $field) {
                        if (is_bool($field['value']) || (isset($field['value']) && ! empty($field['value']))) {
                            $field['user_id'] = $user->id; // Add user Id
                            if (! isset($field['id'])) {
                                $this->validateResponseApi(
                                    $this->field->create(new Request(['attributes' => (array) $field]))
                                );
                            } else {
                                $this->validateResponseApi(
                                    $this->field->update($field['id'], new Request(['attributes' => (array) $field]))
                                );
                            }
                        } else {
                            if (isset($field['id'])) {
                                $this->validateResponseApi(
                                    $this->field->delete($field['id'], new Request(['attributes' => (array) $field]))
                                );
                            }
                        }
                    }
                }

                //Create or Update Addresses
                if (isset($data['addresses'])) {
                    foreach ($data['addresses'] as $address) {
                        $address['user_id'] = $user->id; // Add user Id
                        if (! isset($address['id'])) {
                            $this->validateResponseApi(
                                $this->address->create(new Request(['attributes' => (array) $address]))
                            );
                        } else {
                            $this->validateResponseApi(
                                $this->address->update($address['id'], new Request(['attributes' => (array) $address]))
                            );
                        }
                    }
                }

                //Create or Update Settings
                if (isset($data['settings'])) {
                    foreach ($data['settings'] as $settingName => $setting) {
                        $this->profileSetting->updateOrCreate(
                            ['related_id' => $user->id, 'entity_name' => 'user', 'name' => $settingName],
                            ['related_id' => $user->id, 'entity_name' => 'user', 'name' => $settingName, 'value' => $setting]
                        );
                    }
                }

                // configuring pasword to audit
                if (isset($data['password'])) {
                    $data['password'] = $user->password;
                }

                //Response
                $response = ['data' => $user];
            } else {
                $status = 400;
                $response = ['errors' => $data['email'].' | User Name already exist'];
            }

            //Add value from admin
            if (isset($requestSetting->fromAdmin)) {
                $data['fromAdmin'] = $requestSetting->fromAdmin;
            }

            //dispatch Event
            event(new UserUpdatedEvent($user, $data));

            \DB::commit(); //Commit to DataBase
        } catch (\Exception $e) {
            \DB::rollback(); //Rollback to Data Base
            $status = $this->getStatusError($e->getCode());
            $response = ['errors' => $e->getMessage()];
        }

        //Return response
        return response()->json($response, $status ?? 200);
    }

    /**
     * Change password
     */
    public function changePassword(Request $request)
    {
        \DB::beginTransaction(); //DB Transaction
        try {
            //Auth api controller
            $authApiController = app('Modules\Iprofile\Http\Controllers\Api\AuthApiController');
            $requestLogout = new Request();

            //Get Parameters from URL.
            $params = $request->input('attributes');

            //Validate Request
            $this->validateRequestApi(new UpdatePasswordRequest((array) $params));

            //Try to login and Get Token
            $token = $this->validateResponseApi($authApiController->authAttempt($params));
            $requestLogout->headers->set('Authorization', $token->bearer); //Add token to headers
            $user = Auth::user(); //Get User

            //Check if password exist in history
            $result = $this->userPasswordHistoryService->checkOldPasswords($user, $params);

            //Update password
            $userUpdated = $this->validateResponseApi(
                $this->update($user->id, new request(
                    ['attributes' => [
                        'password' => $params['newPassword'],
                        'id' => $user->id,
                        'is_activated' => true,
                    ]]
                ))
            );

            //Logout token
            $this->validateResponseApi($authApiController->logout($requestLogout));

            $response['data']['messages'] = [
                [
                    'mode' => 'modal',
                    'type' => 'warning',
                    'title' => trans('iprofile::frontend.title.resetPassword'),
                    'message' => trans('iprofile::frontend.messages.password updated'),
                    'persistent' => true,
                    'actions' => [
                        [
                            'label' => trans('iprofile::frontend.title.login'),
                            'toUrl' => url('/iadmin/#/auth/login'),
                        ],
                    ],
                ],
            ];

            \DB::commit(); //Commit to DataBase
        } catch (\Exception $e) {
            \DB::rollback(); //Rollback to Data Base
            $status = $this->getStatusError($e->getCode());
            $response = ['messages' => [['message' => $e->getMessage(), 'type' => 'error']]];
        }

        //Return response
        return response()->json($response ?? ['data' => 'Password updated'], $status ?? 200);
    }

    /**
     * Upload media files
     *
     * @return mixed
     */
    public function mediaUpload(Request $request)
    {
        try {
            $auth = \Auth::user();
            $data = $request->all(); //Get data
            $user_id = $data['user'];
            $name = $data['nameFile'];
            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            $nameFile = $name.'.'.$extension;
            $allowedextensions = ['JPG', 'JPEG', 'PNG', 'GIF', 'ICO', 'BMP', 'PDF', 'DOC', 'DOCX', 'ODT', 'MP3', '3G2', '3GP', 'AVI', 'FLV', 'H264', 'M4V', 'MKV', 'MOV', 'MP4', 'MPG', 'MPEG', 'WMV'];
            $destination_path = 'assets/iprofile/profile/files/'.$user_id.'/'.$nameFile;
            $disk = 'publicmedia';
            if (! in_array(strtoupper($extension), $allowedextensions)) {
                throw new Exception(trans('iprofile::profile.messages.file not allowed'));
            }
            if ($user_id == $auth->id || $auth->hasAccess('user.users.create')) {
                if (in_array(strtoupper($extension), ['JPG', 'JPEG'])) {
                    $image = \Image::make($file);

                    \Storage::disk($disk)->put($destination_path, $image->stream($extension, '90'));
                } else {
                    \Storage::disk($disk)->put($destination_path, \File::get($file));
                }

                $status = 200;
                $response = ['data' => ['url' => $destination_path]];
            } else {
                $status = 403;
                $response = [
                    'error' => [
                        'code' => '403',
                        'title' => trans('iprofile::profile.messages.access denied'),
                    ],
                ];
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            $status = $this->getStatusError($e->getCode());
            $response = ['errors' => $e->getMessage()];
        }

        return response()->json($response ?? ['data' => 'Request successful'], $status ?? 200);
    }

    /**
     * delete media
     *
     * @return mixed
     */
    public function mediaDelete(Request $request)
    {
        try {
            $disk = 'publicmedia';
            $auth = \Auth::user();
            $data = $request->all(); //Get data
            $user_id = $data['user'];
            $dirdata = $request->input('file');

            if ($user_id == $auth->id || $auth->hasAccess('user.users.create')) {
                \Storage::disk($disk)->delete($dirdata);

                $status = 200;
                $response = [
                    'susses' => [
                        'code' => '201',
                        'source' => [
                            'pointer' => url($request->path()),
                        ],
                        'title' => trans('core::core.messages.resource delete'),
                        'detail' => [
                        ],
                    ],
                ];
            } else {
                $status = 403;
                $response = [
                    'error' => [
                        'code' => '403',
                        'title' => trans('iprofile::profile.messages.access denied'),
                    ],
                ];
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            $status = $this->getStatusError($e->getCode());
            $response = ['errors' => $e->getMessage()];
        }

        return response()->json($response ?? ['data' => 'Request successful'], $status ?? 200);
    }

    /**
     * GET USERS BIRTHDAY
     *
     * @return mixed
     */
    public function usersBirthday(Request $request)
    {
        try {
            //Get Parameters from URL.
            $params = $this->getParamsRequest($request);

            //Request to Repository
            $usersData = $this->repoField->usersBirthday($params);

            //Response
            $response = ['data' => $usersData];

            //If request pagination add meta-page
            $params->page ? $response['meta'] = ['page' => $this->pageTransformer($usersData)] : false;
        } catch (\Exception $e) {
            $status = $this->getStatusError($e->getCode());
            $response = ['errors' => $e->getMessage()];
        }

        //Return response
        return response()->json($response ?? ['data' => 'Request successful'], $status ?? 200);
    }

    /**
     * Password Validate Change
     *
     * @return mixed
     */
    public function passwordValidateChange(Request $request)
    {
        try {
            //Get Parameters from URL.
            $params = $this->getParamsRequest($request);

            $user = Auth::user();

            // Default change password
            $shouldChangePassword = false;

            //Default description
            $description = trans('iprofile::frontend.messages.You must change the password');

            // Get setting days
            $settingDays = setting('iprofile::passwordExpiredTime', null, 0);

            // 0 is (Never update)
            if ($settingDays != 0) {
                // Get last history
                $lastPasswordHistory = UserPasswordHistory::where('user_id', $user->id)->latest()->first();

                // User has password history
                if (! empty($lastPasswordHistory)) {
                    $datePassword = $lastPasswordHistory->created_at->format('Y-m-d');
                    $date = Carbon::parse($datePassword);

                    $now = Carbon::now();

                    //Get diference in days
                    $diff = $date->diffInDays($now);

                    if ($diff >= $settingDays) {
                        $shouldChangePassword = true;
                    }
                } else {
                    //The user has no history so he is forced to change and it will be saved in the history
                    $shouldChangePassword = true;
                }
            }

            // Response
            $response['data']['shouldChangePassword'] = $shouldChangePassword;
            if ($shouldChangePassword) {
                $response['data']['description'] = $description;
            }

            // Response Messages like modal
            if ($shouldChangePassword) {
                // Get Workspace User
                $workspace = $this->userService->getUserWorkspace($user);

                $response['data']['messages'] = [
                    [
                        'mode' => 'modal',
                        'type' => 'warning',
                        'title' => trans('iprofile::frontend.title.changePassword'),
                        'message' => trans('iprofile::frontend.messages.resetPasswordModal'),
                        'persistent' => true,
                        'actions' => [
                            [
                                'label' => trans('iprofile::frontend.title.changePassword'),
                                'toUrl' => url("/{$workspace}/#/auth/force-change-password"),
                            ],
                        ],
                    ],
                ];
            }
        } catch (\Exception $e) {
            $status = $this->getStatusError($e->getCode());
            $response = ['messages' => [['message' => $e->getMessage(), 'type' => 'error']]];
        }

        //Return response
        return response()->json($response ?? ['data' => 'Request successful'], $status ?? 200);
    }
}
