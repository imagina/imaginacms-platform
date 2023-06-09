<?php

namespace Modules\Idocs\Entities;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class CategoryTranslation extends Model
{
    use Sluggable;

    public $timestamps = false;

    protected $fillable = ['title', 'description', 'slug', 'meta_title', 'meta_description', 'meta_keywords', 'translatable_options'];

    protected $table = 'idocs__category_translations';

    protected $casts = [
        'translatable_options' => 'array',
    ];

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

    public function getMetaDescriptionAttribute()
    {
        return $this->meta_description ?? substr(strip_tags($this->description ?? ''), 0, 150);
    }

    public function getTranslatableOptionAttribute($value)
    {
        return json_decode($value);
    }

    /**
     * @return mixed
     */
    public function getMetaTitleAttribute()
    {
        return $this->meta_title ?? $this->title;
    }
}
