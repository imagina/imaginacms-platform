<?php

namespace Modules\Iprofile\Http\Controllers\Admin;

use Illuminate\Http\Response;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Iprofile\Entities\Setting;
use Modules\Iprofile\Http\Requests\CreateSettingRequest;
use Modules\Iprofile\Http\Requests\UpdateSettingRequest;
use Modules\Iprofile\Repositories\SettingRepository;

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
    public function index(): Response
    {
        //$departmentsettings = $this->departmentsetting->all();

        return view('Iprofile::admin.departmentsettings.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(): Response
    {
        return view('Iprofile::admin.departmentsettings.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(CreateSettingRequest $request): Response
    {
        $this->departmentsetting->create($request->all());

        return redirect()->route('admin.Iprofile.departmentsetting.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('Iprofile::departmentsettings.title.departmentsettings')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Response
     */
    public function edit(Setting $departmentsetting): Response
    {
        return view('Iprofile::admin.departmentsettings.edit', compact('departmentsetting'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return Response
     */
    public function update(Setting $departmentsetting, UpdateSettingRequest $request): Response
    {
        $this->departmentsetting->update($departmentsetting, $request->all());

        return redirect()->route('admin.Iprofile.departmentsetting.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('Iprofile::departmentsettings.title.departmentsettings')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return Response
     */
    public function destroy(Setting $departmentsetting): Response
    {
        $this->departmentsetting->destroy($departmentsetting);

        return redirect()->route('admin.Iprofile.departmentsetting.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('Iprofile::departmentsettings.title.departmentsettings')]));
    }
}
