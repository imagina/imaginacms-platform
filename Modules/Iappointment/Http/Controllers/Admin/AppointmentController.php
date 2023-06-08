<?php

namespace Modules\Iappointment\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Iappointment\Entities\Appointment;
use Modules\Iappointment\Http\Requests\CreateAppointmentRequest;
use Modules\Iappointment\Http\Requests\UpdateAppointmentRequest;
use Modules\Iappointment\Repositories\AppointmentRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

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
     * @param  CreateAppointmentRequest $request
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
     * @param  Appointment $appointment
     * @return Response
     */
    public function edit(Appointment $appointment)
    {
        return view('iappointment::admin.appointments.edit', compact('appointment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Appointment $appointment
     * @param  UpdateAppointmentRequest $request
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
     * @param  Appointment $appointment
     * @return Response
     */
    public function destroy(Appointment $appointment)
    {
        $this->appointment->destroy($appointment);

        return redirect()->route('admin.iappointment.appointment.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('iappointment::appointments.title.appointments')]));
    }
}
