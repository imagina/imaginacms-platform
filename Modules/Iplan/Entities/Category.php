<?php

namespace Modules\Iplan\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Support\Traits\AuditTrait;

class Category extends Model
{
    use AuditTrait;

    protected $table = 'iplan__categories';

    protected $fillable = [
        'title',
        'slug',
        'description',
        'parent_id',
        'options',
        'status',
    ];

    public function plans()
    {
        return $this->belongsToMany('Modules\Iplan\Entities\Plan', 'iplan__plan_category')->as('plans')->with('category');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }
}
