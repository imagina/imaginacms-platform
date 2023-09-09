<?php

namespace Modules\Iprofile\Entities;

use Illuminate\Database\Eloquent\Model;
use Cartalyst\Sentinel\Roles\EloquentRole;
use Modules\Core\Icrud\Traits\hasEventsWithBindings;
use Modules\Iforms\Support\Traits\Formeable;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

use Astrotomic\Translatable\Translatable;

class Role extends EloquentRole
{
  use Formeable, BelongsToTenant, hasEventsWithBindings, Translatable;

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
