<?php

namespace Modules\Ibooking\Entities;

use Astrotomic\Translatable\Translatable;
use Modules\Core\Icrud\Entities\CrudModel;
use Modules\Media\Support\Traits\MediaRelation;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class Category extends CrudModel
{
  use Translatable, MediaRelation, BelongsToTenant;

  public $transformer = 'Modules\Ibooking\Transformers\CategoryTransformer';
  public $repository = 'Modules\Ibooking\Repositories\CategoryRepository';
  public $requestValidation = [
    'create' => 'Modules\Ibooking\Http\Requests\CreateCategoryRequest',
    'update' => 'Modules\Ibooking\Http\Requests\UpdateCategoryRequest',
  ];

  protected $table = 'ibooking__categories';
  public $translatedAttributes = ['title', 'description', 'slug'];
  protected $casts = ['options' => 'array'];
  protected $fillable = [
    'parent_id',
    'featured',
    'status',
    'options'
  ];

  /**
   * Relation Parent
   * @return mixed
   */
  public function parent()
  {
    return $this->belongsTo('Modules\Ibooking\Entities\Category', 'parent_id');
  }

  /**
   * Relation Children
   * @return mixed
   */
  public function children()
  {
    return $this->hasMany('Modules\Ibooking\Entities\Category', 'parent_id');
  }

  /**
   * Relation many to many with categories
   * @return mixed
   */
  public function services()
  {
    return $this->belongsToMany(Category::class, 'ibooking__service_category');
  }

}
