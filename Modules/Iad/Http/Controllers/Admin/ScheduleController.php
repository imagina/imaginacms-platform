<?php

namespace Modules\Iad\Http\Controllers\Admin;

use Illuminate\Http\Response;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Iad\Entities\Schedule;
use Modules\Iad\Http\Requests\CreateScheduleRequest;
use Modules\Iad\Http\Requests\UpdateScheduleRequest;
use Modules\Iad\Repositories\ScheduleRepository;

class ScheduleController extends AdminBaseController
{
    /**
     * @var ScheduleRepository
     */
    private $schedule;

    public function __construct(ScheduleRepository $schedule)
    {
        parent::__construct();

        $this->schedule = $schedule;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        //$schedules = $this->schedule->all();

        return view('iad::admin.schedules.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return view('iad::admin.schedules.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateScheduleRequest $request): Response
    {
        $this->schedule->create($request->all());

        return redirect()->route('admin.iad.schedule.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('iad::schedules.title.schedules')]));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Schedule $schedule): Response
    {
        return view('iad::admin.schedules.edit', compact('schedule'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Schedule $schedule, UpdateScheduleRequest $request): Response
    {
        $this->schedule->update($schedule, $request->all());

        return redirect()->route('admin.iad.schedule.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('iad::schedules.title.schedules')]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Schedule $schedule): Response
    {
        $this->schedule->destroy($schedule);

        return redirect()->route('admin.iad.schedule.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('iad::schedules.title.schedules')]));
    }
}
