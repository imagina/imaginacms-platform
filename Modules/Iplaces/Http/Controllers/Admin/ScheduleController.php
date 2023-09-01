<?php

namespace Modules\Iplaces\Http\Controllers\Admin;

use Illuminate\Http\Response;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Iplaces\Entities\Schedule;
use Modules\Iplaces\Http\Requests\CreateScheduleRequest;
use Modules\Iplaces\Http\Requests\UpdateScheduleRequest;
use Modules\Iplaces\Repositories\ScheduleRepository;

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
        $schedules = $this->schedule->paginate(20);

        return view('iplaces::admin.schedules.index', compact('schedules'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        $schedules = $this->schedule->paginate(20);

        return view('iplaces::admin.schedules.create', compact('schedules'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateScheduleRequest $request): Response
    {
        try {
            $this->schedule->create($request->all());

            return redirect()->route('admin.iplaces.schedule.index')
                ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('iplaces::schedules.title.schedules')]));
        } catch (\Exception $e) {
            \Log::error($e);

            return redirect()->back()
                ->withError(trans('core::core.messages.resource error', ['name' => trans('iplaces::schedules.title.schedules')]))->withInput($request->all());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Schedule $schedule): Response
    {
        $schedules = $this->schedule->paginate(20);

        return view('iplaces::admin.schedules.edit', compact('schedule', 'schedules'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Schedule $schedule, UpdateScheduleRequest $request): Response
    {
        try {
            if (isset($request['options'])) {
                $options = (array) $request['options'];
            } else {
                $options = [];
            }
            $request['options'] = json_encode($options);

            $this->schedule->update($schedule, $request->all());

            return redirect()->route('admin.iplaces.schedule.index')
                ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('iplaces::schedules.title.schedules')]));
        } catch (\Exception $e) {
            \Log::error($e);

            return redirect()->back()
                ->withError(trans('core::core.messages.resource error', ['name' => trans('iplaces::schedules.title.schedules')]))->withInput($request->all());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Schedule $schedule): Response
    {
        try {
            $this->schedule->destroy($schedule);

            return redirect()->route('admin.iplaces.schedule.index')
                ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('iplaces::schedules.title.schedules')]));
        } catch (\Exception $e) {
            \Log::error($e);

            return redirect()->back()
                ->withError(trans('core::core.messages.resource error', ['name' => trans('iplaces::schedules.title.schedules')]));
        }
    }
}
