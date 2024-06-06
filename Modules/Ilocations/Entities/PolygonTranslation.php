<?php

namespace Modules\Ilocations\Entities;

use Illuminate\Database\Eloquent\Model;

class PolygonTranslation extends Model
{
    public $timestamps = false;

    protected $fillable = [
      'name',
      'description'
    ];
    
    protected $table = 'ilocations__polygon_translations';
}
