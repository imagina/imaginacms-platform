<?php

namespace Modules\Ischedulable\Entities;

use Illuminate\Database\Eloquent\Model;

class DayTranslation extends Model
{
    public $timestamps = false;

    protected $fillable = ['name'];

    protected $table = 'ischedulable__day_translations';
}
