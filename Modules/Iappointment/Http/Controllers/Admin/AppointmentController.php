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
     */
    public function index(): Response
    {
        //$appointments = $this->appointment->all();

        return view('iappointment::admin.appointments.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return view('iappointment::admin.appointments.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateAppointmentRequest $request): Response
    {
        $this->appointment->create($request->all());

        return redirect()->route('admin.iappointment.appointment.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('iappointment::appointments.title.appointments')]));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Appointment $appointment): Response
    {
        return view('iappointment::admin.appointments.edit', compact('appointment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Appointment $appointment, UpdateAppointmentRequest $request): Response
    {
        $this->appointment->update($appointment, $request->all());

        return redirect()->route('admin.iappointment.appointment.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('iappointment::appointments.title.appointments')]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment): Response
    {
        $this->appointment->destroy($appointment);

        return redirect()->route('admin.iappointment.appointment.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('iappointment::appointments.title.appointments')]));
    }
}
