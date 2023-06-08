<?php

namespace Modules\Iappointment\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Modules\Ichat\Entities\Conversation;
use Modules\Media\Support\Traits\MediaRelation;

use Modules\Core\Support\Traits\AuditTrait;

class Appointment extends Model
{
    use Translatable, MediaRelation, AuditTrait;

    protected $table = 'iappointment__appointments';
    public $translatedAttributes = [
        'description'
    ];
    protected $fillable = [
        'category_id',
        'status_id',
        'customer_id',
        'assigned_to',
        'options',
    ];

    protected $casts = [
        'options' => 'array'
    ];

    public function getOptionsAttribute($value)
    {
        return json_decode($value);
    }

    public function setOptionsAttribute($value)
    {
        $this->attributes['options'] = json_encode($value);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function status(){
        return $this->belongsTo(AppointmentStatus::class,'status_id');
    }

    public function statusHistory(){
        return $this->hasMany(AppointmentStatusHistory::class,'appointment_id');
    }

    public function conversation(){
  
      return $this->morphOne(Conversation::class,'entity');
      
    }

    public function fields(){
        return $this->hasMany(AppointmentLead::class);
    }

    public function customer()
    {
        $driver = config('asgard.user.config.driver');
        return $this->belongsTo("Modules\\User\\Entities\\{$driver}\\User", 'customer_id');
    }

    public function assigned()
    {
        $driver = config('asgard.user.config.driver');
        return $this->belongsTo("Modules\\User\\Entities\\{$driver}\\User", 'assigned_to');
    }

    public function assignedHistory()
    {
        $entityPath = "Modules\\User\\Entities\\" . config('asgard.user.config.driver') . "\\User";
        return $this->belongsToMany($entityPath, 'iappointment__appointment_assign_history','appointment_id','assigned_to')->withTimestamps();
    }

}
