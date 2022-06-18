<?php

namespace Modules\Ischedulable\Support\Traits;

use Modules\Ischedulable\Entities\Schedule;
use Modules\Ischedulable\Entities\WorkTime;

trait Schedulable
{
  /**
   * Boot trait method
   */
  public static function bootSchedulable()
  {
    //Listen event after create model
    static::createdWithBindings(function ($model) {
      //Sync schedules
      $model->syncSchedules($model->getEventBindings('createdWithBindings'));
    });
    //Listen event after update model
    static::updatedWithBindings(function ($model) {
      //Sync Schedules
      $model->syncSchedules($model->getEventBindings('updatedWithBindings'));
    });
    //Listen event after delete model
    static::deleted(function ($model) {
      //Delete schedule
      $model->schedule()->delete();
    });
  }

  /**
   * Create schedule to entity
   */
  public function syncSchedules($params)
  {
    //Get schedule data from bindings
    if (isset($params['data']['schedule'])) {
      //Delete Schedule
      $this->schedule()->forceDelete();
      //Validate if has data
      if (is_array($params['data']['schedule'])) {
        $schedule = $params['data']['schedule'];
        //Update Or Create Schedule
        $modelSchedule = Schedule::create(array_merge($schedule, ['entity_id' => $this->id, 'entity_type' => get_class($this)]));
        //Sync Work times
        if (isset($schedule['work_times']) && is_array($schedule['work_times'])) {
          $modelSchedule->workTimes()->createMany($schedule['work_times']);
        }
      }
    }
  }

  /**
   * Relation morphMany Schedules
   */
  public function schedule()
  {
    return $this->morphOne(Schedule::class, 'entity');
  }
}
