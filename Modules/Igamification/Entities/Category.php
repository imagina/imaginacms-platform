<?php

namespace Modules\Igamification\Entities;

use Astrotomic\Translatable\Translatable;
use Modules\Core\Icrud\Entities\CrudModel;

class Category extends CrudModel
{
    use Translatable;

    protected $table = 'igamification__categories';
    public $transformer = 'Modules\Igamification\Transformers\CategoryTransformer';
    public $requestValidation = [
        'create' => 'Modules\Igamification\Http\Requests\CreateCategoryRequest',
        'update' => 'Modules\Igamification\Http\Requests\UpdateCategoryRequest',
      ];
    public $translatedAttributes = [
        'title',
        'description',
        'slug'
    ];
    protected $fillable = [
        'parent_id'
    ];

    protected $casts = [
        'options' => 'array'
    ];


    //============== RELATIONS ==============//

    public function activities()
    {
        return $this->belongsToMany(Category::class, 'igamification__activity_category');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    //============== MUTATORS / ACCESORS ==============//

    public function setOptionsAttribute($value)
    {
        $this->attributes['options'] = json_encode($value);
    }

    public function getOptionsAttribute($value)
    {
        return json_decode($value);
    }


}
