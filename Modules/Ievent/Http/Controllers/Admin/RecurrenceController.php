<?php

namespace Modules\Ievent\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Ievent\Entities\Recurrence;
use Modules\Ievent\Http\Requests\CreateRecurrenceRequest;
use Modules\Ievent\Http\Requests\UpdateRecurrenceRequest;
use Modules\Ievent\Repositories\RecurrenceRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class RecurrenceController extends AdminBaseController
{
    /**
     * @var RecurrenceRepository
     */
    private $recurrence;

    public function __construct(RecurrenceRepository $recurrence)
    {
        parent::__construct();

        $this->recurrence = $recurrence;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$recurrences = $this->recurrence->all();

        return view('ievent::admin.recurrences.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('ievent::admin.recurrences.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateRecurrenceRequest $request
     * @return Response
     */
    public function store(CreateRecurrenceRequest $request)
    {
        $this->recurrence->create($request->all());

        return redirect()->route('admin.ievent.recurrence.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('ievent::recurrences.title.recurrences')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Recurrence $recurrence
     * @return Response
     */
    public function edit(Recurrence $recurrence)
    {
        return view('ievent::admin.recurrences.edit', compact('recurrence'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Recurrence $recurrence
     * @param  UpdateRecurrenceRequest $request
     * @return Response
     */
    public function update(Recurrence $recurrence, UpdateRecurrenceRequest $request)
    {
        $this->recurrence->update($recurrence, $request->all());

        return redirect()->route('admin.ievent.recurrence.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('ievent::recurrences.title.recurrences')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Recurrence $recurrence
     * @return Response
     */
    public function destroy(Recurrence $recurrence)
    {
        $this->recurrence->destroy($recurrence);

        return redirect()->route('admin.ievent.recurrence.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('ievent::recurrences.title.recurrences')]));
    }
}
