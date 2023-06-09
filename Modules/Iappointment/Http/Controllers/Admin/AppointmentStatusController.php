<?php

namespace Modules\Iappointment\Http\Controllers\Admin;

use Illuminate\Http\Response;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Iappointment\Entities\AppointmentStatus;
use Modules\Iappointment\Http\Requests\CreateAppointmentStatusRequest;
use Modules\Iappointment\Http\Requests\UpdateAppointmentStatusRequest;
use Modules\Iappointment\Repositories\AppointmentStatusRepository;

class AppointmentStatusController extends AdminBaseController
{
    /**
     * @var AppointmentStatusRepository
     */
    private $appointmentstatus;

    public function __construct(AppointmentStatusRepository $appointmentstatus)
    {
        parent::__construct();

        $this->appointmentstatus = $appointmentstatus;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(): Response
    {
        //$appointmentstatuses = $this->appointmentstatus->all();

        return view('iappointment::admin.appointmentstatuses.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(): Response
    {
        return view('iappointment::admin.appointmentstatuses.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(CreateAppointmentStatusRequest $request): Response
    {
        $this->appointmentstatus->create($request->all());

        return redirect()->route('admin.iappointment.appointmentstatus.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('iappointment::appointmentstatuses.title.appointmentstatuses')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Response
     */
    public function edit(AppointmentStatus $appointmentstatus): Response
    {
        return view('iappointment::admin.appointmentstatuses.edit', compact('appointmentstatus'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return Response
     */
    public function update(AppointmentStatus $appointmentstatus, UpdateAppointmentStatusRequest $request): Response
    {
        $this->appointmentstatus->update($appointmentstatus, $request->all());

        return redirect()->route('admin.iappointment.appointmentstatus.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('iappointment::appointmentstatuses.title.appointmentstatuses')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return Response
     */
    public function destroy(AppointmentStatus $appointmentstatus): Response
    {
        $this->appointmentstatus->destroy($appointmentstatus);

        return redirect()->route('admin.iappointment.appointmentstatus.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('iappointment::appointmentstatuses.title.appointmentstatuses')]));
    }
}
