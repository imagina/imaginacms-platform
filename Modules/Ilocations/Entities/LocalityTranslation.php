<?php

namespace Modules\Ilocations\Entities;

use Illuminate\Database\Eloquent\Model;

class LocalityTranslation extends Model
{
  public $timestamps = false;
  protected $fillable = [
    'name'
  ];
  protected $table = 'ilocations__locality_translations';
}
