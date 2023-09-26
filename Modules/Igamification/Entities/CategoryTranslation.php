<?php

namespace Modules\Igamification\Entities;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class CategoryTranslation extends Model
{
    use Sluggable;

    public $timestamps = false;

    protected $fillable = [
        'title',
        'description',
        'slug',
        'summary',
    ];

    protected $table = 'igamification__category_translations';

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title',
            ],
        ];
    }
}
