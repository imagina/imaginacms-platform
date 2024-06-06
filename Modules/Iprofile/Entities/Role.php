<?php

namespace Modules\Iprofile\Entities;

use Illuminate\Database\Eloquent\Model;
use Cartalyst\Sentinel\Roles\EloquentRole;

class Role extends EloquentRole
{
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
