<?php

namespace Modules\User\Http\Controllers\Admin;

use Modules\User\Http\Requests\UpdateRoleRequest;
use Modules\User\Permissions\PermissionManager;
use Modules\User\Repositories\RoleRepository;

class RolesController extends BaseUserModuleController
{
    /**
     * @var RoleRepository
     */
    private $role;

    public function __construct(PermissionManager $permissions, RoleRepository $role)
    {
        parent::__construct();

        $this->permissions = $permissions;
        $this->role = $role;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('user::admin.roles.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user::admin.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UpdateRoleRequest $request)
    {
        $data = $this->mergeRequestWithPermissions($request);

        $this->role->create($data);

        return redirect()->route('admin.user.role.index')
            ->withSuccess(trans('user::messages.role created'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        return view('user::admin.roles.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, UpdateRoleRequest $request)
    {
        $data = $this->mergeRequestWithPermissions($request);

        $this->role->update($id, $data);

        return redirect()->route('admin.user.role.index')
            ->withSuccess(trans('user::messages.role updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->role->delete($id);

        return redirect()->route('admin.user.role.index')
            ->withSuccess(trans('user::messages.role deleted'));
    }
}
