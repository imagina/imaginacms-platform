<?php

namespace Modules\Igamification\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Support\Str;
use Modules\Core\Icrud\Entities\CrudModel;
use Modules\Ifillable\Traits\isFillable;
use Modules\Media\Support\Traits\MediaRelation;

class Category extends CrudModel
{
    use Translatable, MediaRelation, isFillable;

    protected $table = 'igamification__categories';

    public $transformer = 'Modules\Igamification\Transformers\CategoryTransformer';

    public $repository = 'Modules\Igamification\Repositories\CategoryRepository';

    public $requestValidation = [
        'create' => 'Modules\Igamification\Http\Requests\CreateCategoryRequest',
        'update' => 'Modules\Igamification\Http\Requests\UpdateCategoryRequest',
    ];

    public $translatedAttributes = [
        'title',
        'description',
        'slug',
        'summary',
    ];

    protected $fillable = [
        'system_name',
        'parent_id',
        'status',
        'options',
    ];

    protected $with = ['users'];

    protected $casts = [
        'options' => 'array',
    ];

    public $dispatchesEventsWithBindings = [
        'retrievedShow' => [
            [
                'path' => 'Modules\Igamification\Events\CategoryWasCompleted',
            ],
        ],
    ];

    //============== RELATIONS ==============//

    public function activities()
    {
        return $this->belongsToMany(Activity::class, 'igamification__activity_category');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function users()
    {
        $driver = config('asgard.user.config.driver');

        return $this->belongsToMany("Modules\\User\\Entities\\{$driver}\\User", 'igamification__category_user');
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

    public function setSystemNameAttribute($value)
    {
        if (empty($value) || is_null($value)) {
            $this->attributes['system_name'] = Str::slug($this->title, '-');
        } else {
            $this->attributes['system_name'] = $value;
        }
    }
}
