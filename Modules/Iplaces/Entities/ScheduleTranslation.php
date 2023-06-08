<?php

namespace Modules\Iplaces\Entities;

use Illuminate\Database\Eloquent\Model;

class ScheduleTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ['title'];
    protected $table = 'iplaces__schedule_translations';
}
