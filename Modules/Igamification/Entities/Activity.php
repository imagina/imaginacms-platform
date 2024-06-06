<?php

namespace Modules\Igamification\Entities;

use Astrotomic\Translatable\Translatable;
use Modules\Core\Icrud\Entities\CrudModel;

class Activity extends CrudModel
{
    use Translatable;

    protected $table = 'igamification__activities';
    public $transformer = 'Modules\Igamification\Transformers\ActivityTransformer';
    public $requestValidation = [
        'create' => 'Modules\Igamification\Http\Requests\CreateActivityRequest',
        'update' => 'Modules\Igamification\Http\Requests\UpdateActivityRequest',
      ];
    public $translatedAttributes = [];
    protected $fillable = [
        'url',
        'category_id'
    ];

    protected $casts = [
        'options' => 'array'
    ];

    public $modelRelations = [
        'categories' => 'belongsToMany',
    ];

    //============== RELATIONS ==============//
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'igamification__activity_category');
    }

    public function users()
    {
        $driver = config('asgard.user.config.driver');
        
        return $this->belongsToMany("Modules\\User\\Entities\\{$driver}\\User", 'igamification__activity_user');
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
