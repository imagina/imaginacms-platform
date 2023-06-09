<?php

namespace Modules\Idocs\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;
use Modules\Core\Support\Traits\AuditTrait;
use Modules\Core\Traits\NamespacedEntity;
use Modules\Isite\Traits\RevisionableTrait;
use Modules\Media\Support\Traits\MediaRelation;

class Category extends Model
{
    use Translatable, MediaRelation, NamespacedEntity, NodeTrait, AuditTrait, RevisionableTrait;

    public $transformer = 'Modules\Idocs\Transformers\CategoryTransformer';

    public $entity = 'Modules\Idocs\Entities\Category';

    public $repository = 'Modules\Idocs\Repositories\CategoryRepository';

    protected $table = 'idocs__categories';

    public $translatedAttributes = [
        'title',
        'description',
        'slug',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'translatable_options',
    ];

    protected $fillable = [
        'parent_id',
        'options',
        'private',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'options' => 'array',
        'private' => 'boolean',
    ];

    /**
     * Relation with category parent
     *
     * @return mixed
     */
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * Relation with categories children
     *
     * @return mixed
     */
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    /**
     * Relation with documents
     *
     * @return mixed
     */
    public function documents()
    {
        return $this->belongsToMany(Document::class, 'idocs__document_category');
    }

    /**
     * @return mixed
     */
    public function getOptionsAttribute($value)
    {
        return json_decode($value);
    }

    /**
     * @return mixed
     */
    public function getUrlAttribute()
    {
        if ($this->private) {
            return \URL::route(\LaravelLocalization::getCurrentLocale().'.idocs.index.private.category', [$this->slug]);
        } else {
            return \URL::route(\LaravelLocalization::getCurrentLocale().'.idocs.index.public.category', [$this->slug]);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */
    /**
     * @return mixed
     */
    public function scopeFirstLevelItems($query)
    {
        return $query->where('depth', '1')
          ->orWhere('depth', null)
          ->orderBy('lft', 'ASC');
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

    // Specify parent id attribute mutator
    public function setParentAttribute($value)
    {
        $this->setParentIdAttribute($value);
    }
}
