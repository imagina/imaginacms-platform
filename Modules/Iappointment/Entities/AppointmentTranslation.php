<?php

namespace Modules\Iappointment\Entities;

use Illuminate\Database\Eloquent\Model;

class AppointmentTranslation extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'description',
    ];

    protected $table = 'iappointment__appointment_translations';
}
