<?php

namespace Modules\Iappointment\Entities;

use Illuminate\Database\Eloquent\Model;

class AppointmentStatusTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'title'
    ];
    protected $table = 'iappointment__appointment_status_translations';
}
