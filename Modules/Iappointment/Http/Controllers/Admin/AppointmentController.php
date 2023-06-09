<?php

namespace Modules\Iappointment\Http\Controllers\Admin;

use Illuminate\Http\Response;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Iappointment\Entities\Appointment;
use Modules\Iappointment\Http\Requests\CreateAppointmentRequest;
use Modules\Iappointment\Http\Requests\UpdateAppointmentRequest;
use Modules\Iappointment\Repositories\AppointmentRepository;

class AppointmentController extends AdminBaseController
{
    /**
     * @var AppointmentRepository
     */
    private $appointment;

    public function __construct(AppointmentRepository $appointment)
    {
        parent::__construct();

        $this->appointment = $appointment;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$appointments = $this->appointment->all();

        return view('iappointment::admin.appointments.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('iappointment::admin.appointments.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(CreateAppointmentRequest $request)
    {
        $this->appointment->create($request->all());

        return redirect()->route('admin.iappointment.appointment.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('iappointment::appointments.title.appointments')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Response
     */
    public function edit(Appointment $appointment)
    {
        return view('iappointment::admin.appointments.edit', compact('appointment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return Response
     */
    public function update(Appointment $appointment, UpdateAppointmentRequest $request)
    {
        $this->appointment->update($appointment, $request->all());

        return redirect()->route('admin.iappointment.appointment.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('iappointment::appointments.title.appointments')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return Response
     */
    public function destroy(Appointment $appointment)
    {
        $this->appointment->destroy($appointment);

        return redirect()->route('admin.iappointment.appointment.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('iappointment::appointments.title.appointments')]));
    }
}