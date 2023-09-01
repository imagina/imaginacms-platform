<?php

namespace Modules\Iappointment\Entities;

use Illuminate\Database\Eloquent\Model;

class AppointmentStatusHistory extends Model
{
    protected $fillable = [
        'appointment_id',
        'status_id',
        'assigned_to',
        'notify',
        'comment',
    ];

    protected $table = 'iappointment__appointment_status_histories';

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function status()
    {
        return $this->belongsTo(AppointmentStatus::class, 'status_id');
    }

    public function assigned()
    {
        $driver = config('asgard.user.config.driver');

        return $this->belongsTo("Modules\\User\\Entities\\{$driver}\\User", 'assigned_to');
    }
}
