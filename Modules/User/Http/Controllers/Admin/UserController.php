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
     *
     * @return Response
     */
    public function index(): Response
    {
        return view('user::admin.users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(): Response
    {
        return view('user::admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(CreateUserRequest $request): Response
    {
        $data = $this->mergeRequestWithPermissions($request);

        $this->user->createWithRoles($data, $request->roles, true);

        return redirect()->route('admin.user.user.index')
            ->withSuccess(trans('user::messages.user created'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Response
     */
    public function edit(): Response
    {
        return view('user::admin.users.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(int $id, UpdateUserRequest $request): Response
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
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy(int $id): Response
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
