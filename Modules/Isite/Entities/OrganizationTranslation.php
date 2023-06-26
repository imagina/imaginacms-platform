<?php

namespace Modules\Isite\Entities;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class OrganizationTranslation extends Model
{
    use Sluggable;

    public $timestamps = false;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'meta_title',
        'meta_description',
        'translatable_options',
    ];

    protected $table = 'isite__organization_translations';

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title',
            ],
        ];
    }
}
