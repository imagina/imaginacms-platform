<?php

namespace Modules\Ievent\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CategoryTranslation extends Model
{
    public $timestamps = false;

    protected $table = 'ievent__category_translations';

    protected $fillable = [
        'title',
        'slug',
        'description',
    ];

    protected function setSlugAttribute($value)
    {
        if ($this->parent_id == 0) {
            if (! empty($value)) {
                $this->attributes['slug'] = Str::slug($value, '-');
            } else {
                $this->attributes['slug'] = Str::slug($this->title, '-');
            }
        } else {
            $this->attributes['slug'] = $this->parent->slug.'/'.Str::slug($this->title, '-');
        }
    }
}
