<?php

namespace Modules\Ischedulable\Entities;

use Astrotomic\Translatable\Translatable;
use Modules\Core\Support\Traits\AuditTrait;
use Modules\Core\Icrud\Entities\CrudModel;

class Day extends CrudModel
{
  use Translatable;

  public $transformer = 'Modules\Ischedulable\Transformers\DayTransformer';
  public $requestValidation = [
    'create' => 'Modules\Ischedulable\Http\Requests\CreateDayRequest',
    'update' => 'Modules\Ischedulable\Http\Requests\UpdateDayRequest',
  ];
  protected $table = 'ischedulable__days';
  public $translatedAttributes = ['name'];
  protected $fillable = ['iso', 'status'];
}
