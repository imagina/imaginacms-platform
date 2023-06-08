<?php

namespace Modules\Icheckin\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Modules\User\Entities\Sentinel\User;

class Shift extends Model
{


    protected $table = 'icheckin__shifts';
 
  protected $fillable = [
    "checkin_at",
    "checkout_at",
    "checkin_by",
    "created_by",
    "checkout_by",
    "period_elapsed",
    'geo_location',
    'request_id',
    'approval_id',
    'options',
    'job_id'
  ];
  
  protected $with = [
    "checkinBy",
    "checkoutBy",
    "createdBy"
  ];
  
  protected $fakeColumns = ['options','geo_location'];
  
  protected $casts = [
    'options' => 'array',
    'geo_location' => 'array',
  ];
  
  public function createdBy()
  {
    return $this->hasOne(User::class,'id','created_by')->with('fields');
  }
  
  public function checkinBy()
  {
    return $this->hasOne(User::class,'id','checkin_by')->with('fields');
  }
  
  public function checkoutBy()
  {
    return $this->hasOne(User::class,'id','checkout_by')->with('fields');
  }
  
  public function getOptionsAttribute($value)
  {
    $options = json_decode($value);
    $time = strtotime($this->attributes['updated_at']);
    
    if(isset($options->mainImage))
      $options->mainImage = url($options->mainImage).'?'.$time;
    
    return $options;
  }
  
  public function setOptionsAttribute($value)
  {
    $this->attributes['options'] = json_encode($value);
  }
  
  public function getGeoLocationAttribute($value)
  {
    return json_decode($value);
    
  }
  
  public function setGeoLocationAttribute($value)
  {
    $this->attributes['geo_location'] = json_encode($value);
  }
}
