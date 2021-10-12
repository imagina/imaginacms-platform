<?php

namespace Modules\Notification\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Rule extends Model
{

    protected $table = 'notification__rules';

    protected $fillable = [
      "name",
      "entity_name",
      "event_path",
      "conditions",
      "settings",
      "status"
    ];

  protected $fakeColumns = ['conditions','settings'];

  protected $casts = [
    'conditions' => 'array',
    'settings' => 'array'
  ];
  public function getConditionsAttribute($value) {
    return json_decode($value);
  }

  public function setConditionsAttribute($value) {
    $this->attributes['conditions'] = json_encode($value);
  }


public function getSettingsAttribute($value) {
  return json_decode($value);
}

public function setSettingsAttribute($value) {
  $this->attributes['settings'] = json_encode($value);
}

}
