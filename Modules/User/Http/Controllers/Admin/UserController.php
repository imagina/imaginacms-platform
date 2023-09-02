<?php

namespace Modules\User\Http\Controllers\Admin;

use Illuminate\Http\Response;
use Modules\User\Contracts\Authentication;
use Modules\User\Events\UserHasBegunResetProcess;
use Modules\User\Http\Requests\CreateUserRequest;
use Modules\User\Http\Requests\UpdateUserRequest;
use Modules\User\Permissions\PermissionManager;
use Modules\User\Repositories\RoleRepository;
use Modules\User\Repositories\UserRepository;

class UserController extends BaseUserModuleController
{
    /**
     * @var UserRepository
     */
    private $user;

    /**
     * @var RoleRepository
     */
    private $role;

    /**
     * @var Authentication
     */
    private $auth;

    public function __construct(
        PermissionManager $permissions,
        UserRepository $user,
        RoleRepository $role,
        Authentication $auth
    ) {
        parent::__construct();

        $this->permissions = $permissions;
        $this->user = $user;
        $this->role = $role;
        $this->auth = $auth;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('user::admin.users.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user::admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateUserRequest $request)
    {
        $data = $this->mergeRequestWithPermissions($request);

        $this->user->createWithRoles($data, $request->roles, true);

        return redirect()->route('admin.user.user.index')
            ->withSuccess(trans('user::messages.user created'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        return view('user::admin.users.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, UpdateUserRequest $request)
    {
        $data = $this->mergeRequestWithPermissions($request);

        $this->user->updateAndSyncRoles($id, $data, $request->roles);

        if ($request->get('button') === 'index') {
            return redirect()->route('admin.user.user.index')
                ->withSuccess(trans('user::messages.user updated'));
        }

        return redirect()->back()
            ->withSuccess(trans('user::messages.user updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->user->delete($id);

        return redirect()->route('admin.user.user.index')
            ->withSuccess(trans('user::messages.user deleted'));
    }

    public function sendResetPassword($user, Authentication $auth)
    {
        $user = $this->user->find($user);
        $code = $auth->createReminderCode($user);

        event(new UserHasBegunResetProcess($user, $code));

        return redirect()->route('admin.user.user.edit', $user->id)
            ->withSuccess(trans('user::auth.reset password email was sent'));
    }
}
