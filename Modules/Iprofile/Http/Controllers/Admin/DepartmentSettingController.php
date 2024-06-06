<?php

namespace Modules\Iprofile\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Iprofile\Entities\Setting;
use Modules\Iprofile\Http\Requests\CreateSettingRequest;
use Modules\Iprofile\Http\Requests\UpdateSettingRequest;
use Modules\Iprofile\Repositories\SettingRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class DepartmentSettingController extends AdminBaseController
{
    /**
     * @var SettingRepository
     */
    private $departmentsetting;

    public function __construct(SettingRepository $departmentsetting)
    {
        parent::__construct();

        $this->departmentsetting = $departmentsetting;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$departmentsettings = $this->departmentsetting->all();

        return view('Iprofile::admin.departmentsettings.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('Iprofile::admin.departmentsettings.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateSettingRequest $request
     * @return Response
     */
    public function store(CreateSettingRequest $request)
    {
        $this->departmentsetting->create($request->all());

        return redirect()->route('admin.Iprofile.departmentsetting.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('Iprofile::departmentsettings.title.departmentsettings')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Setting $departmentsetting
     * @return Response
     */
    public function edit(Setting $departmentsetting)
    {
        return view('Iprofile::admin.departmentsettings.edit', compact('departmentsetting'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Setting $departmentsetting
     * @param  UpdateSettingRequest $request
     * @return Response
     */
    public function update(Setting $departmentsetting, UpdateSettingRequest $request)
    {
        $this->departmentsetting->update($departmentsetting, $request->all());

        return redirect()->route('admin.Iprofile.departmentsetting.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('Iprofile::departmentsettings.title.departmentsettings')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Setting $departmentsetting
     * @return Response
     */
    public function destroy(Setting $departmentsetting)
    {
        $this->departmentsetting->destroy($departmentsetting);

        return redirect()->route('admin.Iprofile.departmentsetting.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('Iprofile::departmentsettings.title.departmentsettings')]));
    }
}
