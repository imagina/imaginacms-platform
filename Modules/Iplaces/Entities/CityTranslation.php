<?php

namespace Modules\Iplaces\Entities;

use Illuminate\Database\Eloquent\Model;

class CityTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ['title','description'];
    protected $table = 'iplaces__city_translations';
}
