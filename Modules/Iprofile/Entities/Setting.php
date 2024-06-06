<?php

namespace Modules\Iprofile\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Modules\User\Entities\Sentinel\User;

class Setting extends Model
{

  protected $table = 'iprofile__settings';

  protected $fillable = [
    'related_id',
    'entity_name',
    'value',
    'name',
    'type'
  ];

  public function department()
  {
    $this->belognsTo(Department::class, 'related_id')->where('entity_name', 'user');
  }

  public function user()
  {
    $this->belognsTo(User::class, 'related_id')->where('entity_name', 'department');
  }

  public function getValueAttribute($value)
  {

    return json_decode($value);

  }

  public function setValueAttribute($value)
  {

    $this->attributes['value'] = json_encode($value);

  }
}
