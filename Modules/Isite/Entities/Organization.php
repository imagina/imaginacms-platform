<?php

namespace Modules\Isite\Entities;

use Astrotomic\Translatable\Translatable;
use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;
use Modules\Core\Support\Traits\AuditTrait;

class Organization extends BaseTenant
{
  use AuditTrait,Translatable;
  
  protected $table = 'isite__organizations';
  
  public $translatedAttributes = [
    'title',
    'slug',
    'description',
    'meta_title',
    'meta_description',
    'translatable_options'
  ];
  protected $fillable = [
    'options',
    'user_id',
    'featured',
    'permissions',
    'status',
    'sort_order'
  ];
  
  protected $casts = [
    'options' => 'array'
  ];
  
  
  public static function getCustomColumns(): array
  {
    return [
      'options',
      'user_id',
      'featured',
      'permissions',
      'status',
      'sort_order',
      'created_by',
      'updated_by',
      'deleted_by',
    ];
  }
  
  public function getIncrementing()
{
    return true;
  }
  
  public function users()
  {
  
    $driver = config('asgard.user.config.driver');
    return $this->belongsToMany("Modules\\User\\Entities\\{$driver}\\User", 'isite__user_organization')
      ->withPivot('id', 'permissions', 'role_id')
      ->withTimestamps();
  }
}
