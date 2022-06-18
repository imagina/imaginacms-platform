<?php

namespace Modules\Ilocations\Entities;

use Astrotomic\Translatable\Translatable;
use Modules\Core\Icrud\Entities\CrudModel;

class Locality extends CrudModel
{
  use Translatable;

  protected $table = 'ilocations__localities';
  public $transformer = 'Modules\Ilocations\Transformers\LocalityTransformer';
  public $requestValidation = [
    'create' => 'Modules\Ilocations\Http\Requests\CreateLocalityRequest',
    'update' => 'Modules\Ilocations\Http\Requests\UpdateLocalityRequest',
  ];
  public $translatedAttributes = [
    'name'
  ];
  protected $fillable = [
    'code',
    'province_id',
    'country_id',
    "city_id"
  ];
}
