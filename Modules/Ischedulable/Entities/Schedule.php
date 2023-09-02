<?php

namespace Modules\Ischedulable\Entities;

use Carbon\Carbon as Time;
use Modules\Core\Icrud\Entities\CrudModel;

class Schedule extends CrudModel
{
    public $transformer = 'Modules\Ischedulable\Transformers\ScheduleTransformer';

    public $repository = 'Modules\Ischedulable\Repositories\ScheduleRepository';

    public $requestValidation = [
        'create' => 'Modules\Ischedulable\Http\Requests\CreateScheduleRequest',
        'update' => 'Modules\Ischedulable\Http\Requests\UpdateScheduleRequest',
    ];

    protected $table = 'ischedulable__schedules';

    protected $fillable = [
        'zone',
        'status',
        'entity_id',
        'entity_type',
        'start_date',
        'end_date',
    ];

    /**
     * Get the parent schedulable model.
     */
    public function schedulable()
    {
        return $this->morphTo();
    }

    /**
     * Relation BelongsTomany WorkTimes
     *
     * @return mixed
     */
    public function workTimes()
    {
        return $this->hasMany(WorkTime::class);
    }

    /**
     * Return schedule shifts
     *
     * @return mixed
     */
    public function getShifts($params = [])
    {
        $response = []; //Instance response
        $workTimes = $this->workTimes; //Get schedule worktimes

        //Instance startDate and endDate range to generate shifts
        $startDate = isset($params['dateRange'][0]) ? Time::parse($params['dateRange'][0]) : Time::now();
        $endDate = isset($params['dateRange'][1]) ? Time::parse($params['dateRange'][1]) : $startDate->copy()->addDay(6);

        //Check the workTimes and dates are right
        if ($workTimes->count() && $endDate->greaterThan($startDate)) {
            while ($endDate->greaterThanOrEqualTo($startDate)) {
                //Get workTimes of the current day of week from startDate (cardon DayWeek 0 to Sunday is changed by 7)
                $workTimesToDay = $workTimes->where('day_id', ($startDate->dayOfWeek ? $startDate->dayOfWeek : 7));
                //Get shift by workTime and set current startDate
                foreach ($workTimesToDay as $workTime) {
                    //Obtain the available shifts by workTime
                    $workTimeShifts = $workTime->getShifts([
                        'shiftTime' => $params['shiftTime'] ?? null,
                        'timeRange' => $params['timeRange'] ?? null,
                    ]);
                    foreach ($workTimeShifts as $wtShift) {
                        //Set extra data to workTime Shift
                        $wtShift = array_merge($wtShift, ['calendarDate' => $startDate->toDateString(), 'isBusy' => 0, 'busyBy' => null]);
                        //Check if shift is busy
                        foreach (($params['busyShifts'] ?? []) as $bsShift) {
                            $isBusy = false; //Instance is busy

                            //Check de calendarDate are the same
                            if ($startDate->toDateString() == $bsShift['calendarDate']) {
                                ksort($bsShift); //sort busy shift

                                //Parse all times
                                $shiftStartTime = Time::parse($wtShift['startTime']);
                                $shiftEndTime = Time::parse($wtShift['endTime']);
                                $bsStartTime = Time::parse($bsShift['startTime']);
                                $bsEndTime = Time::parse($bsShift['endTime']);

                                // Validate that both time ranges do not have time in common
                                if ($shiftStartTime->between($bsStartTime, $bsEndTime) && $shiftStartTime->lessThan($bsEndTime)) {
                                    $isBusy = 1;
                                }
                                if ($shiftEndTime->between($bsStartTime, $bsEndTime) && $shiftEndTime->greaterThan($bsStartTime)) {
                                    $isBusy = 1;
                                }
                                if ($bsStartTime->between($shiftStartTime, $shiftEndTime) && $bsStartTime->lessThan($shiftEndTime)) {
                                    $isBusy = 1;
                                }
                                if ($bsEndTime->between($shiftStartTime, $shiftEndTime) && $bsEndTime->greaterThan($shiftStartTime)) {
                                    $isBusy = 1;
                                }

                                //Set busy data to workTime shift
                                if ($isBusy ?? false) {
                                    $wtShift = array_merge($wtShift, ['isBusy' => 1, 'busyBy' => $bsShift]);
                                }
                            }
                        }
                        //Sort workTime shift
                        ksort($wtShift);
                        //add shift to response
                        $response[] = $wtShift;
                    }
                }
                //Add one day to startDate to while loop
                $startDate->addDay(1);
            }
        }

        //Order shifts by calendarDate, day and startTime asc way
        $response = collect($response)->sortBy([['calendarDate', 'asc'], ['dayId', 'asc'], ['startTime', 'asc']]);

        //Response
        return $response;
    }
}
