<?php

namespace Modules\Iprofile\Entities;

use Cartalyst\Sentinel\Roles\EloquentRole;
use Modules\Core\Icrud\Traits\hasEventsWithBindings;
use Modules\Iforms\Support\Traits\Formeable;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class Role extends EloquentRole
{
    use Formeable, BelongsToTenant, hasEventsWithBindings;

    protected $fillable = [
        'slug',
        'name',
    'permissions'
  ];

  public $translatedAttributes = [
    'title'
    ];

    public $tenantWithCentralData = false;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    public function settings()
    {
        return $this->hasMany(Setting::class, 'related_id')->where('entity_name', 'role');
    }
}
