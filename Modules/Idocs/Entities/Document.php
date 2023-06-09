<?php

namespace Modules\Idocs\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laracasts\Presenter\PresentableTrait;
use Modules\Core\Support\Traits\AuditTrait;
use Modules\Core\Traits\NamespacedEntity;
use Modules\Idocs\Presenters\DocumentPresenter;
use Modules\Iprofile\Entities\Department;
use Modules\Isite\Traits\RevisionableTrait;
use Modules\Media\Support\Traits\MediaRelation;

class Document extends Model
{
    use Translatable, MediaRelation, NamespacedEntity, PresentableTrait, AuditTrait, RevisionableTrait;

    public $transformer = 'Modules\Idocs\Transformers\DocumentTransformer';

    public $entity = 'Modules\Idocs\Entities\Document';

    public $repository = 'Modules\Idocs\Repositories\DocumentRepository';

    protected $table = 'idocs__documents';

    public $translatedAttributes = ['title', 'description'];

    protected $fillable = [
        'user_identification',
        'key',
        'email',
        'options',
        'category_id',
        'user_id',
        'role_id',
        'status',
        'private',
    ];

    protected $presenter = DocumentPresenter::class;

    private $auth;

    protected $casts = [
        'options' => 'array',
        'private' => 'boolean',
    ];

    public function __construct(array $attributes = [])
    {
        $this->auth = Auth::user();
        parent::__construct($attributes);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'idocs__document_category');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function users()
    {
        $driver = config('asgard.user.config.driver');

        return $this->belongsToMany("Modules\\User\\Entities\\{$driver}\\User", 'idocs__document_user', 'document_id', 'user_id')
          ->withTimestamps()
          ->withPivot(['key', 'downloaded']);
    }

    public function departments()
    {
        $driver = config('asgard.user.config.driver');

        return $this->belongsToMany(Department::class, 'idocs_document_department')->withTimestamps();
    }

    public function user()
    {
        $driver = config('asgard.user.config.driver');

        return $this->belongsTo("Modules\\User\\Entities\\{$driver}\\User");
    }

    public function tracking()
    {
        if ($this->private) {
            return $this->hasOne(DocumentUser::class)->where('user_id', $this->auth->id ?? null);
        } else {
            return $this->belongsTo(Document::class, 'id', 'id');
        }
    }

    /**
     * @return mixed
     */
    public function getFileAttribute()
    {
        $thumbnail = $this->files()->where('zone', 'file')->first();
        if (! $thumbnail) {
            return null;
        } else {
            $image = [
                'mimeType' => $thumbnail->mimetype,
                'path' => $thumbnail->path_string,
                'size' => $thumbnail->filesize,
            ];
        }

        return json_decode(json_encode($image));
    }

    public function setKeyAttribute($value)
    {
        $key = Str::random(48);

        $this->attributes['key'] = $key;
    }

    /**
     * @return mixed
     */
    public function getUrlAttribute()
    {
        return \URL::route(\LaravelLocalization::getCurrentLocale().'.idocs.show.document', $this->id);
    }

    /**
     * @return mixed
     */
    public function getPublicUrlAttribute()
    {
        $tracking = $this->tracking;

        return \URL::route(\LaravelLocalization::getCurrentLocale().'.idocs.show.documentByKey', [$this->id, $tracking->key ?? $this->key]);
    }

    /**
     * @return mixed
     */
    public function getIconImageAttribute()
    {
        $thumbnail = $this->files()->where('zone', 'iconimage')->first();
        if (! $thumbnail) {
            return null;
        } else {
            $image = [
                'mimeType' => $thumbnail->mimetype,
                'path' => $thumbnail->path_string,
            ];
        }

        return json_decode(json_encode($image));
    }
}
