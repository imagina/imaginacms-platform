<?php

namespace Modules\Ilocations\Entities;

use Illuminate\Database\Eloquent\Model;

class ProvinceTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = [
    	'name'
    ];
    protected $table = 'ilocations__province_translations';
}
