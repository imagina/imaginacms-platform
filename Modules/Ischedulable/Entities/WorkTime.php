<?php

namespace Modules\Ischedulable\Entities;

use Carbon\Carbon as Time;
use Modules\Core\Icrud\Entities\CrudModel;

class WorkTime extends CrudModel
{
    public $transformer = 'Modules\Ischedulable\Transformers\WorkTimeTransformer';

    public $repository = 'Modules\Ischedulable\Repositories\WorkTimeRepository';

    public $requestValidation = [
        'create' => 'Modules\Ischedulable\Http\Requests\CreateWorkTimeRequest',
        'update' => 'Modules\Ischedulable\Http\Requests\UpdateWorkTimeRequest',
    ];

    protected $table = 'ischedulable__work_times';

    protected $fillable = [
        'schedule_id',
        'day_id',
        'start_time',
        'end_time',
        'shift_time',
    ];

    /**
     * Relation belongsTo Day
     *
     * @return mixed
     */
    public function day()
    {
        return $this->belongsTo(Day::class);
    }

    /**
     * Relation belongsTo Day
     *
     * @return mixed
     */
    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    /**
     * Return shifts by intervals
     */
    public function getShifts($params = [])
    {
        $response = []; //Default response
        $modelRelations = $this->getRelations(); //Get model relations
        $startTime = Time::parse($this->start_time); // Parse start Time
        $endTime = Time::parse($this->end_time); // Parse end time
        $shiftTime = $params['shiftTime'] ?? $this->shiftTime ?? 30;

        //Instance time range allowed to generate shifts
        $startAllowedRange = isset($params['timeRange'][0]) ? Time::parse($params['timeRange'][0]) : Time::parse('00:00:00');
        $endAllowedRange = isset($params['timeRange'][1]) ? Time::parse($params['timeRange'][1]) : Time::parse('23:59:59');

        //Only if endTime is greater then startThan generate shifts
        if ($endTime->greaterThan($startTime) && $endAllowedRange->greaterThan($startAllowedRange)) {
            $startShiftTime = $startTime->copy(); // Instance startShiftTime
            $endShiftTime = $startTime->copy()->addMinutes($shiftTime); // instance endShiftTime
      //generate shifts
            while ($endTime->greaterThanOrEqualTo($endShiftTime)) {
                //Check if shift is into allowed range time
                if ($startShiftTime->greaterThanOrEqualTo($startAllowedRange) && $endShiftTime->lessThanOrEqualTo($endAllowedRange)) {
                    // Instance shift data
                    $shift = [
                        'scheduleId' => $this->schedule_id,
                        'dayId' => $this->day_id,
                        'startTime' => $startShiftTime->totimeString(),
                        'endTime' => $endShiftTime->totimeString(),
                    ];
                    //Add day relation if exist to shift
                    if (isset($modelRelations['day'])) {
                        $shift['day'] = $modelRelations['day'];
                    }
                    // Sort shits
                    ksort($shift);
                    //Add shift to response
                    $response[] = $shift;
                }
                //Replace startShiftTime with endShiftTime
                $startShiftTime = $endShiftTime->copy();
                //Add shifTime to endShiftTime
                $endShiftTime->addMinutes($shiftTime);
            }
        }

        //Response
        return $response;
    }
}
