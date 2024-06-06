<?php

namespace Modules\Iblog\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Laracasts\Presenter\PresentableTrait;
use Modules\Core\Traits\NamespacedEntity;
use Modules\Iblog\Presenters\PostPresenter;
use Modules\Media\Entities\File;
use Modules\Media\Support\Traits\MediaRelation;
use Modules\Tag\Contracts\TaggableInterface;
use Modules\Tag\Traits\TaggableTrait;

class Post extends Model implements TaggableInterface
{
    use Translatable, PresentableTrait, NamespacedEntity, TaggableTrait, MediaRelation;

    protected static $entityNamespace = 'asgardcms/post';

    protected $table = 'iblog__posts';

    protected $fillable = [
        'options',
        'category_id',
        'user_id',
        'status',
        'created_at',
    ];
    public $translatedAttributes = [
        'title',
        'description',
        'slug',
        'summary',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'translatable_options'
    ];
    protected $presenter = PostPresenter::class;


    protected $casts = [
        'options' => 'array'
    ];


    public function __construct(array $attributes = [])
    {
        if (config()->has('asgard.iblog.config.fillable.post')) {
            $this->fillable = config('asgard.iblog.config.fillable.post');
        }

        parent::__construct($attributes);
    }

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
        if (!$thumbnail) {
            $image = [
                'mimeType' => 'image/jpeg',
                'path' => url('modules/iblog/img/post/default.jpg')
            ];
        } else {
            $image = [
                'mimeType' => $thumbnail->mimetype,
                'path' => $thumbnail->path_string
            ];
        }
        return json_decode(json_encode($image));
    }

    public function getMainImageAttribute()
    {
        $thumbnail = $this->files()->where('zone', 'mainimage')->first();
        if (!$thumbnail) {
            if (isset($this->options->mainimage)) {
                $image = [
                    'mimeType' => 'image/jpeg',
                    'path' => url($this->options->mainimage)
                ];
            } else {
                $image = [
                    'mimeType' => 'image/jpeg',
                    'path' => url('modules/iblog/img/post/default.jpg')
                ];
            }
        } else {
            $image = [
                'mimeType' => $thumbnail->mimetype,
                'path' => $thumbnail->path_string
            ];
        }
        return json_decode(json_encode($image));

    }

    public function getGalleryAttribute()
    {

        $images = \Storage::disk('publicmedia')->files('assets/iblog/post/gallery/' . $this->id);
        if (count($images)) {
            $response = array();
            foreach ($images as $image) {
                $response = ["mimetype" => "image/jpeg", "path" => $image];
            }
        } else {
            $gallery = $this->filesByZone('gallery')->get();
            $response = [];
            foreach ($gallery as $img) {
                array_push($response, [
                    'mimeType' => $img->mimetype,
                    'path' => $img->path_string
                ]);
            }

        }

        return json_decode(json_encode($response));
    }

    /**
     * URL post
     * @return string
     */
    public function getUrlAttribute()
    {
  
      $category = $this->category;
      if (!isset($category->slug)) {
        if (!empty($this->categories)) {
          $category = $this->categories->first();
          if (!isset($category->slug)) {
            $category = Category::take(1)->get()->first();
          }
        } else {
          $category = Category::take(1)->get()->first();
        }
      }
        
        return \URL::route(\LaravelLocalization::getCurrentLocale() . '.iblog.'.$category->slug.'.post', [$this->slug]);

    }

    /**
     * Magic Method modification to allow dynamic relations to other entities.
     * @var $value
     * @var $destination_path
     * @return string
     */
    public function __call($method, $parameters)
    {
        #i: Convert array to dot notation
        $config = implode('.', ['asgard.iblog.config.relations.post', $method]);

        #i: Relation method resolver
        if (config()->has($config)) {
            $function = config()->get($config);

            return $function($this);
        }

        #i: No relation found, return the call to parent (Eloquent) to handle it.
        return parent::__call($method, $parameters);
    }

}
