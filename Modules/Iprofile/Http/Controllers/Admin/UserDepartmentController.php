<?php

namespace Modules\Iprofile\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Iprofile\Entities\UserDepartment;
use Modules\Iprofile\Http\Requests\CreateUserDepartmentRequest;
use Modules\Iprofile\Http\Requests\UpdateUserDepartmentRequest;
use Modules\Iprofile\Repositories\UserDepartmentRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class UserDepartmentController extends AdminBaseController
{
    /**
     * @var UserDepartmentRepository
     */
    private $userdepartment;

    public function __construct(UserDepartmentRepository $userdepartment)
    {
        parent::__construct();

        $this->userdepartment = $userdepartment;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$userdepartments = $this->userdepartment->all();

        return view('Iprofile::admin.userdepartments.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('Iprofile::admin.userdepartments.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateUserDepartmentRequest $request
     * @return Response
     */
    public function store(CreateUserDepartmentRequest $request)
    {
        $this->userdepartment->create($request->all());

        return redirect()->route('admin.Iprofile.userdepartment.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('Iprofile::userdepartments.title.userdepartments')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  UserDepartment $userdepartment
     * @return Response
     */
    public function edit(UserDepartment $userdepartment)
    {
        return view('Iprofile::admin.userdepartments.edit', compact('userdepartment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UserDepartment $userdepartment
     * @param  UpdateUserDepartmentRequest $request
     * @return Response
     */
    public function update(UserDepartment $userdepartment, UpdateUserDepartmentRequest $request)
    {
        $this->userdepartment->update($userdepartment, $request->all());

        return redirect()->route('admin.Iprofile.userdepartment.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('Iprofile::userdepartments.title.userdepartments')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  UserDepartment $userdepartment
     * @return Response
     */
    public function destroy(UserDepartment $userdepartment)
    {
        $this->userdepartment->destroy($userdepartment);

        return redirect()->route('admin.Iprofile.userdepartment.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('Iprofile::userdepartments.title.userdepartments')]));
    }
}
