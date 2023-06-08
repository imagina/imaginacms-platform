<?php

namespace Modules\Iad\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Icrud\Entities\CrudModel;

class Schedule extends CrudModel
{
  public $transformer = 'Modules\Iad\Transformers\ScheduleTransformer';
  public $entity = 'Modules\Iad\Entities\Schedule';
  public $repository = 'Modules\Iad\Repositories\ScheduleRepository';
  public $requestValidation = [
    'create' => 'Modules\Iad\Http\Requests\CreateScheduleRequest',
    'update' => 'Modules\Iad\Http\Requests\UpdateScheduleRequest',
  ];
  protected $table = 'iad__schedules';
  public $translatedAttributes = [];
  protected $fillable = [
    'iso',
    'name',
    'ad_id',
    'start_time',
    'end_time',
    'options'
  ];
  protected $fakeColumns = ['options'];
  protected $casts = [
    'options' => 'array'
  ];
}
