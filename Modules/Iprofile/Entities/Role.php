<?php

namespace Modules\Iprofile\Entities;

use Illuminate\Database\Eloquent\Model;
use Cartalyst\Sentinel\Roles\EloquentRole;
use Modules\Iforms\Support\Traits\Formeable;

class Role extends EloquentRole
{
  use Formeable;
  
  protected $fillable = [
    'slug',
    'name',
    'permissions'
  ];

  public function settings()
  {
    return $this->hasMany(Setting::class, 'related_id')->where('entity_name', 'role');
  }
}
