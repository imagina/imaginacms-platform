<?php

namespace Modules\Iblog\Entities;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class CategoryTranslation extends Model
{
    use Sluggable;

    public $timestamps = false;

    protected $table = 'iblog__category_translations';

    protected $fillable = ['title', 'description', 'status', 'slug', 'meta_title', 'meta_description', 'meta_keywords', 'translatable_options'];

    protected $casts = [
        'translatable_options' => 'array',
    ];

    /**
     * Return the sluggable configuration array for this model.
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
        $options = json_decode($value);

        return $options;
    }

    /**
     * @return mixed
     */
    public function getMetaTitleAttribute()
    {
        return $this->meta_title ?? $this->title;
    }
}
