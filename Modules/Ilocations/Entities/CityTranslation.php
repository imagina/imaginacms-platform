<?php

namespace Modules\Ilocations\Entities;

use Illuminate\Database\Eloquent\Model;

class CityTranslation extends Model
{
  public $timestamps = false;
  protected $fillable = [
    'name'
  ];
  protected $table = 'ilocations__city_translations';
}
