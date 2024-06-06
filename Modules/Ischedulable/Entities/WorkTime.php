<?php

namespace Modules\Ischedulable\Entities;

use Modules\Core\Icrud\Entities\CrudModel;
use Modules\Ischedulable\Entities\Day;
use Modules\Ischedulable\Entities\Schedule;
use Carbon\Carbon as Time;

class WorkTime extends CrudModel
{
  public $transformer = 'Modules\Ischedulable\Transformers\WorkTimeTransformer';
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
    'shift_time'
  ];

  /**
   * Relation belongsTo Day
   * @return mixed
   */
  public function day()
  {
    return $this->belongsTo(Day::class);
  }

  /**
   * Relation belongsTo Day
   * @return mixed
   */
  public function schedule()
  {
    return $this->belongsTo(Schedule::class);
  }

  /**
   * Return shifts in intervals
   */
  public function getShifts()
  {
    $response = [];//Default response
    $modelRelations = $this->getRelations();//Get model relations
    $startTime = Time::parse($this->start_time);// Parse start Time
    $endTime = Time::parse($this->end_time);// Parse end time

    //Only if endTime is greater then startThan generate shifts
    if ($endTime->greaterThan($startTime)) {
      $startShiftTime = $startTime->copy();// Instance startShiftTime
      $endShiftTime = $startTime->copy()->addMinutes($this->shift_time);// instance endShiftTime
      //generate shifts
      while ($endTime->greaterThanOrEqualTo($endShiftTime)) {
        // Instance shift data
        $shift = [
          'scheduleId' => $this->schedule_id,
          'dayId' => $this->day_id,
          'startTime' => $startShiftTime->totimeString(),
          'endTime' => $endShiftTime->totimeString(),
        ];
        //Add day relation if exist to shift
        if (isset($modelRelations['day'])) $shift['day'] = $modelRelations['day'];
        // Sort shits
        ksort($shift);
        //Add shift to response
        $response[] = $shift;
        //Replace startShiftTime with endShiftTime
        $startShiftTime = $endShiftTime->copy();
        //Add shifTime to endShiftTime
        $endShiftTime->addMinutes($this->shift_time);
      }
    }

    //Response
    return $response;
  }
}
