<?php

namespace Modules\Iblog\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Support\Str;
use Kalnoy\Nestedset\NodeTrait;
use Laracasts\Presenter\PresentableTrait;
use Modules\Core\Icrud\Entities\CrudModel;
use Modules\Core\Traits\NamespacedEntity;
use Modules\Ifillable\Traits\isFillable;
use Modules\Isite\Traits\Typeable;
use Modules\Media\Support\Traits\MediaRelation;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class Category extends CrudModel
{
    use Translatable, MediaRelation, PresentableTrait,
        NamespacedEntity, NodeTrait, BelongsToTenant,
        Typeable, isFillable;

    public $transformer = 'Modules\Iblog\Transformers\CategoryTransformer';

    public $entity = 'Modules\Iblog\Entities\Category';

    public $repository = 'Modules\Iblog\Repositories\CategoryRepository';

    public $requestValidation = [
        'create' => 'Modules\Iblog\Http\Requests\CreateCategoryRequest',
        'update' => 'Modules\Iblog\Http\Requests\UpdateCategoryRequest',
    ];

    protected $table = 'iblog__categories';

    protected $fillable = [
        'parent_id',
        'show_menu',
        'featured',
        'internal',
        'sort_order',
        'external_id',
        'options',
    ];

    public $translatedAttributes = ['title', 'status', 'description', 'slug', 'meta_title', 'meta_description', 'meta_keywords', 'translatable_options'];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'options' => 'array',
    ];

    protected $with = [
        'fields',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function parent()
    {
        return $this->belongsTo('Modules\Iblog\Entities\Category', 'parent_id');
    }

    public function children()
    {
        return $this->hasMany('Modules\Iblog\Entities\Category', 'parent_id');
    }

    public function posts()
    {
        return $this->belongsToMany('Modules\Iblog\Entities\Post', 'iblog__post__category')->as('posts')->with('category');
    }

    public function getOptionsAttribute($value)
    {
        try {
            return json_decode($value);
        } catch (\Exception $e) {
            return json_decode($value);
        }
    }

    public function getSecondaryImageAttribute()
    {
        $thumbnail = $this->files()->where('zone', 'secondaryimage')->first();
        if (! $thumbnail) {
            $image = [
                'mimeType' => 'image/jpeg',
                'path' => url('modules/iblog/img/post/default.jpg'),
            ];
        } else {
            $image = [
                'mimeType' => $thumbnail->mimetype,
                'path' => $thumbnail->path_string,
            ];
        }

        return json_decode(json_encode($image));
    }

    public function getMainImageAttribute()
    {
        $thumbnail = $this->files()->where('zone', 'mainimage')->first();
        if (! $thumbnail) {
            if (isset($this->options->mainimage)) {
                $image = [
                    'mimeType' => 'image/jpeg',
                    'path' => url($this->options->mainimage),
                ];
            } else {
                $image = [
                    'mimeType' => 'image/jpeg',
                    'path' => url('modules/iblog/img/post/default.jpg'),
                ];
            }
        } else {
            $image = [
                'mimeType' => $thumbnail->mimetype,
                'path' => $thumbnail->path_string,
            ];
        }

        return json_decode(json_encode($image));
    }

    public function getUrlAttribute($locale = null)
    {
        $url = '';

        if ($this->internal) {
            return '';
        }
        if (empty($this->slug)) {
            $category = $this->getTranslation(\LaravelLocalization::getDefaultLocale());
            $this->slug = $category->slug ?? '';
        }

        $currentLocale = $locale ?? locale();
        if (! is_null($currentLocale)) {
            $this->slug = $this->getTranslation($currentLocale)->slug;
        }

        if (empty($this->slug)) {
            return '';
        }

        $currentDomain = ! empty($this->organization_id) ? tenant()->domain ?? tenancy()->find($this->organization_id)->domain :
          parse_url(config('app.url'), PHP_URL_HOST);

        if (! (request()->wantsJson() || Str::startsWith(request()->path(), 'api'))) {
            if (config('app.url') != $currentDomain) {
                $savedDomain = config('app.url');
                config(['app.url' => 'https://'.$currentDomain]);
            }
            $url = \LaravelLocalization::localizeUrl('/'.$this->slug, $currentLocale);

            if (isset($savedDomain) && ! empty($savedDomain)) {
                config(['app.url' => $savedDomain]);
            }
        }

        return $url;
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */
    public function scopeFirstLevelItems($query)
    {
        return $query->where('depth', '1')
          ->orWhere('depth', null)
          ->orderBy('lft', 'ASC');
    }

    public function __call($method, $parameters)
    {
        //i: Convert array to dot notation
        $config = implode('.', ['asgard.iblog.config.relations.category', $method]);

        //i: Relation method resolver
        if (config()->has($config)) {
            $function = config()->get($config);
            $bound = $function->bindTo($this);

            return $bound();
        }

        //i: No relation found, return the call to parent (Eloquent) to handle it.
        return parent::__call($method, $parameters);
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
