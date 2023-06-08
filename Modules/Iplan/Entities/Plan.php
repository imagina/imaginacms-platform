<?php

namespace Modules\Iplan\Entities;

use Astrotomic\Translatable\Translatable;
use Modules\Core\Icrud\Entities\CrudModel;
use Modules\Isite\Traits\WithProduct;
use Modules\Iplan\Entities\PlanType;
use Modules\Media\Support\Traits\MediaRelation;

class Plan extends CrudModel
{
  use Translatable, WithProduct, MediaRelation;

  protected $table = 'iplan__plans';
  public $transformer = 'Modules\Iplan\Transformers\PlanTransformer';
  public $repository = 'Modules\Iplan\Repositories\PlanRepository';
  public $requestValidation = [
    'create' => 'Modules\Iplan\Http\Requests\CreatePlanRequest',
    'update' => 'Modules\Iplan\Http\Requests\UpdatePlanRequest',
  ];
  public $translatedAttributes = [
    "name",
    "description",
  ];
  protected $fillable = [
    "internal",
    "frequency_id",
    "category_id",
    "options",
    "price",
    "type",
    "trial"
  ];

  protected $casts = [
    'options' => 'array'
  ];

  public function setOptionsAttribute($value)
  {
    $this->attributes['options'] = json_encode($value);
  }


  public function getOptionsAttribute($value)
  {
    return json_decode($value);
  }

  public function limits()
  {
    return $this->belongsToMany(Limit::class, 'iplan__plan_limits');
  }

  public function category()
  {
    return $this->belongsTo(Category::class, "category_id");
  }

  public function categories()
  {
    return $this->belongsToMany(Category::class, 'iplan__plan_category');
  }

  public function product()
  {
    return $this->morphOne("Modules\\Icommerce\\Entities\\Product", "entity");
  }

  public function getTypeNameAttribute()
  {
    $type = new PlanType();
    return $type->get($this->type);
  }

  public function getFrequencyLabelAttribute()
  {
    return (new Frequency())->get($this->frequency_id);
  }

  /*
  * Product - Required shipping
  * Is used in trait WithProduct
  */
  public function getRequiredShippingAttribute()
  {
    return false;
  }

}
