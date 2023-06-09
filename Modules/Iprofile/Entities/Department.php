<?php

namespace Modules\Iprofile\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\User\Entities\Sentinel\User;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class Department extends Model
{
    use BelongsToTenant;

    protected $table = 'iprofile__departments';

    protected $fillable = [
        'title',
        'parent_id',
        'is_internal',
        'options',
    ];

    protected $fakeColumns = ['options'];

    protected $casts = [
        'options' => 'array',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'iprofile__user_department');
    }

    public function parent()
    {
        return $this->belongsTo(Department::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Department::class, 'parent_id');
    }

    public function settings()
    {
        return $this->hasMany(Setting::class, 'related_id')->where('entity_name', 'department');
    }

    public function getOptionsAttribute($value)
    {
        return json_decode($value);
    }

    public function setOptionsAttribute($value)
    {
        $this->attributes['options'] = json_encode($value);
    }
}
