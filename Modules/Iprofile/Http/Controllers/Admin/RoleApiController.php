<?php

namespace Modules\Iprofile\Http\Controllers\Admin;

use Illuminate\Http\Response;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Iprofile\Entities\RoleApi;
use Modules\Iprofile\Http\Requests\CreateRoleApiRequest;
use Modules\Iprofile\Http\Requests\UpdateRoleApiRequest;
use Modules\Iprofile\Repositories\RoleApiRepository;

class RoleApiController extends AdminBaseController
{
    /**
     * @var RoleApiRepository
     */
    private $roleapi;

    public function __construct(RoleApiRepository $roleapi)
    {
        parent::__construct();

        $this->roleapi = $roleapi;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$roleapis = $this->roleapi->all();

        return view('Iprofile::admin.roleapis.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Iprofile::admin.roleapis.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateRoleApiRequest $request)
    {
        $this->roleapi->create($request->all());

        return redirect()->route('admin.Iprofile.roleapi.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('Iprofile::roleapis.title.roleapis')]));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RoleApi $roleapi)
    {
        return view('Iprofile::admin.roleapis.edit', compact('roleapi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoleApi $roleapi, UpdateRoleApiRequest $request)
    {
        $this->roleapi->update($roleapi, $request->all());

        return redirect()->route('admin.Iprofile.roleapi.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('Iprofile::roleapis.title.roleapis')]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RoleApi $roleapi)
    {
        $this->roleapi->destroy($roleapi);

        return redirect()->route('admin.Iprofile.roleapi.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('Iprofile::roleapis.title.roleapis')]));
    }
}
