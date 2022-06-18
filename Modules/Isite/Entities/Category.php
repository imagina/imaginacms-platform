<?php

namespace Modules\Isite\Entities;

use Astrotomic\Translatable\Translatable;
use Modules\Core\Icrud\Entities\CrudModel;
use Kalnoy\Nestedset\NodeTrait;
use Modules\Media\Support\Traits\MediaRelation;
use Illuminate\Support\Str;

class Category extends CrudModel
{
    use Translatable, MediaRelation, NodeTrait;

    protected $table = 'isite__categories';
    public $transformer = 'Modules\Isite\Transformers\CategoryTransformer';
    public $requestValidation = [
        'create' => 'Modules\Isite\Http\Requests\CreateCategoryRequest',
        'update' => 'Modules\Isite\Http\Requests\UpdateCategoryRequest',
      ];
    public $translatedAttributes = [
      'title', 'description', 'slug', 'meta_title', 'meta_description', 'meta_keywords', 'translatable_options'
    ];
    protected $fillable = [
      'parent_id',
      'show_menu',
      'featured',
      'internal',
      'status',
      'sort_order',
      'options'
    ];
  
  /**
   * The attributes that should be casted to native types.
   *
   * @var array
   */
  protected $casts = [
    'options' => 'array'
  ];
  
  public function organizations()
  {
    return $this->hasMany(Organization::class);
  }
  
  public function getUrlAttribute()
  {
    
    return ""; //TODO: falta definir la lógica de esta url pública
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
