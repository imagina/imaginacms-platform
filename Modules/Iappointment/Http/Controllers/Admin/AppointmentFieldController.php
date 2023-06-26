<?php

namespace Modules\Iappointment\Http\Controllers\Admin;

use Illuminate\Http\Response;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Iappointment\Entities\AppointmentField;
use Modules\Iappointment\Http\Requests\CreateAppointmentFieldRequest;
use Modules\Iappointment\Http\Requests\UpdateAppointmentFieldRequest;
use Modules\Iappointment\Repositories\AppointmentFieldRepository;

class AppointmentFieldController extends AdminBaseController
{
    /**
     * @var AppointmentFieldRepository
     */
    private $appointmentfield;

    public function __construct(AppointmentFieldRepository $appointmentfield)
    {
        parent::__construct();

        $this->appointmentfield = $appointmentfield;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        //$appointmentfields = $this->appointmentfield->all();

        return view('iappointment::admin.appointmentfields.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return view('iappointment::admin.appointmentfields.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateAppointmentFieldRequest $request): Response
    {
        $this->appointmentfield->create($request->all());

        return redirect()->route('admin.iappointment.appointmentfield.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('iappointment::appointmentfields.title.appointmentfields')]));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AppointmentField $appointmentfield): Response
    {
        return view('iappointment::admin.appointmentfields.edit', compact('appointmentfield'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AppointmentField $appointmentfield, UpdateAppointmentFieldRequest $request): Response
    {
        $this->appointmentfield->update($appointmentfield, $request->all());

        return redirect()->route('admin.iappointment.appointmentfield.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('iappointment::appointmentfields.title.appointmentfields')]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AppointmentField $appointmentfield): Response
    {
        $this->appointmentfield->destroy($appointmentfield);

        return redirect()->route('admin.iappointment.appointmentfield.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('iappointment::appointmentfields.title.appointmentfields')]));
    }
}
