<?php

namespace Modules\Icheckin\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use Translatable;

    protected $table = 'icheckin__requests';
  
  protected $fillable = [
    "checkin_at",
    "checkout_at",
    "geo_location",
    "user_id",
    "status",
    "type",
    "shift_id"
  ];
  
  protected $with = [
    "CheckInBy",
    "CheckOutBy"
  ];
  
  public function CheckInBy()
  {
    return $this->hasOne(User::class,'id','checkin_by')->with('fields');
  }
  
  public function CheckOutBy()
  {
    return $this->hasOne(User::class,'id','checkout_by')->with('fields');
  }
}
