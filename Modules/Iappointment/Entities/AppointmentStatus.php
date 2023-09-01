<?php

namespace Modules\Iappointment\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class AppointmentStatus extends Model
{
    use Translatable;

    protected $table = 'iappointment__appointment_statuses';

    public $translatedAttributes = [
        'title',
    ];

    protected $fillable = [
        'parent_id',
        'status',
    ];

    public function parent()
    {
        return $this->belongsTo(AppointmentStatus::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(AppointmentStatus::class, 'parent_id');
    }

    public function appointments()
    {
        return $this->belongsToMany(Appointment::class, AppointmentStatusHistory::class, 'status_id', 'appointment_id');
    }
}
