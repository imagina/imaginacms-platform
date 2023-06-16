<?php

namespace Modules\Iad\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Support\Str;
use Kalnoy\Nestedset\NodeTrait;
use Modules\Core\Icrud\Entities\CrudModel;
use Modules\Media\Support\Traits\MediaRelation;

class Category extends CrudModel
{
    use Translatable, NodeTrait, MediaRelation;

    public $transformer = 'Modules\Iad\Transformers\CategoryTransformer';

    public $entity = 'Modules\Iad\Entities\Category';

    public $repository = 'Modules\Iad\Repositories\CategoryRepository';

    public $requestValidation = [
        'create' => 'Modules\Iad\Http\Requests\CreateCategoryRequest',
        'update' => 'Modules\Iad\Http\Requests\UpdateCategoryRequest',
    ];

    protected $table = 'iad__categories';

    public $translatedAttributes = ['title', 'description', 'slug'];

    protected $fillable = [
        'parent_id',
        'status',
        'options',
        'sort_order',
    ];

    protected $fakeColumns = ['options'];

    protected $casts = [
        'options' => 'array',
    ];

    public function parent()
    {
        return $this->belongsTo('Modules\Iad\Entities\Category', 'parent_id');
    }

    public function children()
    {
        return $this->hasMany('Modules\Iad\Entities\Category', 'parent_id');
    }

    public function ads()
    {
        return $this->belongsToMany(Ad::class, 'iad__ad_category');
    }

    public function getUrlAttribute()
    {
        $url = '';

        $currentLocale = \LaravelLocalization::getCurrentLocale();

        if (! (request()->wantsJson() || Str::startsWith(request()->path(), 'api'))) {
            $url = tenant_route(request()->getHost(), $currentLocale.'.iad.ad.index.category', [$this->slug]);
        }

        return $url;
    }

    public function getLftName()
    {
        return 'lft';
    }

    public function getRgtName()
    {
        return 'rgt';
    }

    public function getDepthName()
    {
        return 'depth';
    }

    public function getParentIdName()
    {
        return 'parent_id';
    }
}
