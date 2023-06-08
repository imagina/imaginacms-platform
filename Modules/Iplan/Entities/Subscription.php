<?php

namespace Modules\Iplan\Entities;

use Illuminate\Database\Eloquent\Model;

use Modules\Iplan\Entities\Status;

class Subscription extends Model
{

    protected $table = 'iplan__subscriptions';
    protected $fillable = [
      "name",
      "description",
      "category_name",
      "entity",
      "entity_id",
      "plan_id",
      "frequency",
      "start_date",
      "end_date",
      "status",
      "options",
      "next_plan_id"
    ];

    protected $casts = [
        'options' => 'array',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function setOptionsAttribute($value)
    {
        $this->attributes['options'] = json_encode($value);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function getOptionsAttribute($value)
    {
        return json_decode($value);
    }

    public function limits()
    {
      return $this->hasMany(SubscriptionLimit::class,"subscription_id");
    }

    public function entityData(){
        $driver = config('asgard.user.config.driver');
        return $this->belongsTo($this->entity ?? "Modules\\User\\Entities\\{$driver}\\User","entity_id");
    }

    public function related($related){
        return $this->morphedByMany($related, "related", "iplan__subscription_related")->withTimestamps();
    }

    public function getStatusNameAttribute()
    {
        $status = new Status();
        return $status->get($this->status);
    }

    public function getIsAvailableAttribute()
    {

        $isAvailable = false;
        $today = date("Y-m-d H:i:s");

        if($this->start_date<=$today && $this->end_date>=$today)
            $isAvailable = true;

        return $isAvailable;

    }

}
