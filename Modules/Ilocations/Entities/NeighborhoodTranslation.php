<?php

namespace Modules\Ilocations\Entities;

use Illuminate\Database\Eloquent\Model;

class NeighborhoodTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ["name"];
    protected $table = 'ilocations__neighborhood_translations';
}
