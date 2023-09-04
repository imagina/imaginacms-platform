<?php

namespace Modules\Iblog\Entities;

use Astrotomic\Translatable\Translatable;
use Laracasts\Presenter\PresentableTrait;
use Modules\Core\Icrud\Entities\CrudModel;
use Modules\Core\Traits\NamespacedEntity;
use Modules\Iblog\Presenters\PostPresenter;
use Modules\Isite\Traits\Typeable;
use Modules\Media\Support\Traits\MediaRelation;
use Modules\Tag\Contracts\TaggableInterface;
use Modules\Tag\Traits\TaggableTrait;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class Post extends CrudModel implements TaggableInterface
{
    use Translatable, PresentableTrait, NamespacedEntity,
        TaggableTrait, MediaRelation, BelongsToTenant,
        Typeable;

    protected static $entityNamespace = 'asgardcms/post';

    public $transformer = 'Modules\Iblog\Transformers\PostTransformer';

    public $entity = 'Modules\Iblog\Entities\Post';

    public $repository = 'Modules\Iblog\Repositories\PostRepository';

    public $requestValidation = [
        'create' => 'Modules\Iblog\Http\Requests\CreatePostRequest',
        'update' => 'Modules\Iblog\Http\Requests\UpdatePostRequest',
    ];

    protected $table = 'iblog__posts';

    protected $fillable = [
        'options',
        'category_id',
        'user_id',
        'featured',
        'sort_order',
        'external_id',
        'created_at',
        'date_available',
    ];

    public $translatedAttributes = [
        'title',
        'description',
        'slug',
        'summary',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'translatable_options',
        'status',
    ];

    protected $presenter = PostPresenter::class;

  protected $dates = [
    'date_available'
  ];

    protected $casts = [
        'date_available' => 'datetime',
        'options' => 'array',
    ];

    protected $revisionEnabled = true;

    protected $revisionCleanup = true;

    protected $historyLimit = 100;

    protected $revisionCreationsEnabled = true;

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'iblog__post__category');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        $driver = config('asgard.user.config.driver');

        return $this->belongsTo("Modules\\User\\Entities\\{$driver}\\User");
    }

    public function getOptionsAttribute($value)
    {
        try {
            return json_decode(json_decode($value));
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

    public function getGalleryAttribute()
    {
        $images = \Storage::disk('publicmedia')->files('assets/iblog/post/gallery/'.$this->id);
        if (count($images)) {
            $response = [];
            foreach ($images as $image) {
                $response = ['mimetype' => 'image/jpeg', 'path' => $image];
            }
        } else {
            $gallery = $this->filesByZone('gallery')->get();
            $response = [];
            foreach ($gallery as $img) {
                array_push($response, [
                    'mimeType' => $img->mimetype,
                    'path' => $img->path_string,
                ]);
            }
        }

        return json_decode(json_encode($response));
    }

    /**
     * URL post
     */
    public function getUrlAttribute($locale = null)
    {
        if (empty($this->slug)) {
            $post = $this->getTranslation(\LaravelLocalization::getDefaultLocale());
            $this->slug = $post->slug ?? '';
        }

        $currentLocale = $locale ?? locale();
        if (! is_null($locale)) {
            $this->slug = $this->getTranslation($currentLocale)->slug;
            $this->category = $this->category->getTranslation($currentLocale);
        }

        if (empty($this->slug)) {
            return '';
        }

        $currentDomain = ! empty($this->organization_id) ? tenant()->domain ?? tenancy()->find($this->organization_id)->domain :
          parse_url(config('app.url'), PHP_URL_HOST);

        if (config('app.url') != $currentDomain) {
            $savedDomain = config('app.url');
            config(['app.url' => 'https://'.$currentDomain]);
        }

        if (isset($this->options->urlCoder) && ! empty($this->options->urlCoder) && $this->options->urlCoder == 'onlyPost') {
            $url = \LaravelLocalization::localizeUrl('/'.$this->slug, $currentLocale);
        } else {
            if (empty($this->category->slug)) {
                $url = '';
            } else {
                $url = \LaravelLocalization::localizeUrl('/'.$this->category->slug.'/'.$this->slug, $currentLocale);
            }
        }

        if (isset($savedDomain) && ! empty($savedDomain)) {
            config(['app.url' => $savedDomain]);
        }

        return $url;
    }

    /**
     * Magic Method modification to allow dynamic relations to other entities.
     *
     *
     * @var
     * @var
     */
    public function __call($method, $parameters)
    {
        //i: Convert array to dot notation
        $config = implode('.', ['asgard.iblog.config.relations.post', $method]);

        //i: Relation method resolver
        if (config()->has($config)) {
            $function = config()->get($config);

            return $function($this);
        }

        //i: No relation found, return the call to parent (Eloquent) to handle it.
        return parent::__call($method, $parameters);
    }
}
