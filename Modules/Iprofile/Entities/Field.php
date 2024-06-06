<?php

namespace Modules\Iprofile\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Modules\User\Entities\Sentinel\User;
use Modules\Media\ValueObjects\MediaPath;

class Field extends Model
{

  protected $table = 'iprofile__fields';

  protected $fillable = [
    'user_id',
    'value',
    'name',
    'type'
  ];

  protected $fakeColumns = ['value'];

  protected $casts = [
    'value' => 'array'
  ];

  public function user()
  {
    return $this->belongsTo(User::class, 'user_id');
  }

  public function getValueAttribute($value)
  {
    if ($this->name == 'mainImage')
      return new MediaPath(json_decode($value));
    else return json_decode($value);
  }

  public function setValueAttribute($value)
  {
    if ($this->name == 'mainImage') {
      $url = $value;
      //Crear URL
      if (strpos($url, 'http') !== false){
        $url = str_replace(new MediaPath('/'), '', $value);
        $url = substr($url, 0, (strpos($url, "?") ?? strlen($url)));
      }
      //Change value
      $this->attributes['value'] = json_encode($url);
    } else $this->attributes['value'] = json_encode($value);
  }
}
