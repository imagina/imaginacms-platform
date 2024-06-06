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
  }

  /**
   * Create schedule to entity
   */
  public function syncSchedules($params)
  {
    //Get schedules from parameters
    $schedules = isset($params['data']['schedules']) ? $params['data']['schedules'] : $params;
    //Delete all schedules
    $this->schedules()->forceDelete();
    //Add new schedules
    foreach ($schedules as $schedule) {
      //Create Schedule
      $modelSchedule = Schedule::create(array_merge($schedule, ['entity_id' => $this->id, 'entity_type' => get_class($this)]));
      //Sync Work times
      if ($schedule['work_times']) {
        foreach ($schedule['work_times'] as $workTime) {
          WorkTime::create(array_merge($workTime, ['schedule_id' => $modelSchedule->id]));
        }
      }
    }
  }

  /**
   * Relation morphMany Schedules
   */
  public function schedules()
  {
    return $this->morphMany(Schedule::class, 'entity');
  }

  /**
   * Return schedule by zone name
   * @param $zoneName
   */
  public function getScheduleByZone($zoneName)
  {
    return $this->schedules->where('zone', $zoneName)->first();
  }
}
