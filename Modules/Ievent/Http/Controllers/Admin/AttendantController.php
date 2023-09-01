<?php

namespace Modules\Ievent\Http\Controllers\Admin;

use Illuminate\Http\Response;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Ievent\Entities\Attendant;
use Modules\Ievent\Http\Requests\CreateAttendantRequest;
use Modules\Ievent\Http\Requests\UpdateAttendantRequest;
use Modules\Ievent\Repositories\AttendantRepository;

class AttendantController extends AdminBaseController
{
    /**
     * @var AttendantRepository
     */
    private $attendant;

    public function __construct(AttendantRepository $attendant)
    {
        parent::__construct();

        $this->attendant = $attendant;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        //$attendants = $this->attendant->all();

        return view('ievent::admin.attendants.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return view('ievent::admin.attendants.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateAttendantRequest $request): Response
    {
        $this->attendant->create($request->all());

        return redirect()->route('admin.ievent.attendant.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('ievent::attendants.title.attendants')]));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Attendant $attendant): Response
    {
        return view('ievent::admin.attendants.edit', compact('attendant'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Attendant $attendant, UpdateAttendantRequest $request): Response
    {
        $this->attendant->update($attendant, $request->all());

        return redirect()->route('admin.ievent.attendant.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('ievent::attendants.title.attendants')]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attendant $attendant): Response
    {
        $this->attendant->destroy($attendant);

        return redirect()->route('admin.ievent.attendant.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('ievent::attendants.title.attendants')]));
    }
}
