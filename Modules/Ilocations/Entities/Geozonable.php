<?php

namespace Modules\Ilocations\Entities;

use Illuminate\Database\Eloquent\Model;

class Geozonable extends Model
{
  protected $fillable = [
    'geozone_id',
    'geozonable_id',
    'geozonable_type',
  ];
}
