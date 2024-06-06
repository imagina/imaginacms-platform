<?php

namespace Modules\Igamification\Entities;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class CategoryTranslation extends Model
{

    use Sluggable;

    public $timestamps = false;
    protected $fillable = [
        'title',
        'description',
        'slug'
    ];
    protected $table = 'igamification__category_translations';



    public function sluggable()
    {
        return [
            'slug' => [
                   'source' => 'title'
            ]
        ];
    }

}
