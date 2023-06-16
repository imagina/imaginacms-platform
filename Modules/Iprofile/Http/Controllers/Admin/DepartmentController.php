<?php

namespace Modules\Iprofile\Http\Controllers\Admin;

use Illuminate\Http\Response;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Iprofile\Entities\Department;
use Modules\Iprofile\Http\Requests\CreateDepartmentRequest;
use Modules\Iprofile\Http\Requests\UpdateDepartmentRequest;
use Modules\Iprofile\Repositories\DepartmentRepository;

class DepartmentController extends AdminBaseController
{
    /**
     * @var DepartmentRepository
     */
    private $department;

    public function __construct(DepartmentRepository $department)
    {
        parent::__construct();

        $this->department = $department;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$departments = $this->department->all();

        return view('Iprofile::admin.departments.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('Iprofile::admin.departments.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(CreateDepartmentRequest $request)
    {
        $this->department->create($request->all());

        return redirect()->route('admin.Iprofile.department.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('Iprofile::departments.title.departments')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Response
     */
    public function edit(Department $department)
    {
        return view('Iprofile::admin.departments.edit', compact('department'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return Response
     */
    public function update(Department $department, UpdateDepartmentRequest $request)
    {
        $this->department->update($department, $request->all());

        return redirect()->route('admin.Iprofile.department.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('Iprofile::departments.title.departments')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return Response
     */
    public function destroy(Department $department)
    {
        $this->department->destroy($department);

        return redirect()->route('admin.Iprofile.department.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('Iprofile::departments.title.departments')]));
    }
}
