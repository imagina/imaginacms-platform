<?php

namespace Modules\Iplaces\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Iplaces\Entities\Schedule;
use Modules\Iplaces\Http\Requests\CreateScheduleRequest;
use Modules\Iplaces\Http\Requests\UpdateScheduleRequest;
use Modules\Iplaces\Events\ScheduleWasCreated;
use Modules\Iplaces\Repositories\ScheduleRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

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
     *
     * @return Response
     */
    public function index()
    {
        $schedules = $this->schedule->paginate(20);

        return view('iplaces::admin.schedules.index', compact('schedules'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {

        $schedules = $this->schedule->paginate(20);

        return view('iplaces::admin.schedules.create',compact('schedules'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateScheduleRequest $request
     * @return Response
     */
    public function store(CreateScheduleRequest $request)
    {
        try{
            $this->schedule->create($request->all());

            return redirect()->route('admin.iplaces.schedule.index')
                ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('iplaces::schedules.title.schedules')]));

        }catch (\Exception $e){
            \Log::error($e);
            return redirect()->back()
                ->withError(trans('core::core.messages.resource error', ['name' => trans('iplaces::schedules.title.schedules')]))->withInput($request->all());

        }


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Schedule $schedule
     * @return Response
     */
    public function edit(Schedule $schedule)
    {

            $schedules = $this->schedule->paginate(20);
            return view('iplaces::admin.schedules.edit', compact('schedule','schedules'));



    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Schedule $schedule
     * @param  UpdateScheduleRequest $request
     * @return Response
     */
    public function update(Schedule $schedule, UpdateScheduleRequest $request)
    {
        try{
            if(isset($request['options'])){
                $options=(array)$request['options'];
            }else{$options = array();}
            $request['options'] = json_encode($options);

            $this->schedule->update($schedule, $request->all());

            return redirect()->route('admin.iplaces.schedule.index')
                ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('iplaces::schedules.title.schedules')]));

        }catch (\Exception $e){
            \Log::error($e);
            return redirect()->back()
                ->withError(trans('core::core.messages.resource error', ['name' => trans('iplaces::schedules.title.schedules')]))->withInput($request->all());

        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Schedule $schedule
     * @return Response
     */
    public function destroy(Schedule $schedule)
    {
        try{
            $this->schedule->destroy($schedule);

            return redirect()->route('admin.iplaces.schedule.index')
                ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('iplaces::schedules.title.schedules')]));

        }catch (\Exception $e){

            \Log::error($e);
            return redirect()->back()
                ->withError(trans('core::core.messages.resource error', ['name' => trans('iplaces::schedules.title.schedules')]));

        }

    }
}
