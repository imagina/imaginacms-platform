<?php

namespace Modules\Iplan\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class SubscriptionLimit extends Model
{

  protected $table = 'iplan__subscription_limits';
  protected $fillable = [
    "name",
    "subscription_id",
    "entity",
    "attribute",
    "attribute_value",
    "quantity",
    "quantity_used",
    "start_date",
    "end_date",
    "changed_subscription_date",
    "type",
    "options"
  ];

  protected $casts = [
    'options' => 'array'
  ];

  public function subscription()
  {
    return $this->belongsTo(Subscription::class,"subscription_id");
  }

  //============== MUTATORS / ACCESORS ==============//

  public function setOptionsAttribute($value)
  {
    $this->attributes['options'] = json_encode($value);
  }

  public function getOptionsAttribute($value)
  {
    return json_decode($value);
  }

  public function getQuantityAvailableAttribute(){

    $result = $this->quantity - $this->quantity_used;

    return abs($result);
  }

}
