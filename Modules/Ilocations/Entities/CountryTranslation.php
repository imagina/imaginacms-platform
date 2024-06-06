<?php

namespace Modules\Ilocations\Entities;

use Illuminate\Database\Eloquent\Model;

class CountryTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = [
    	'name',
    	'full_name'
    ];
    protected $table = 'ilocations__country_translations';

}
