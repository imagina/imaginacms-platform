<?php

namespace Modules\Ibooking\Entities;

use Astrotomic\Translatable\Translatable;
use Modules\Core\Icrud\Entities\CrudModel;

use Modules\Ibooking\Entities\Category;
use Modules\Ibooking\Entities\Resource;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

//Traits
use Modules\Isite\Traits\WithProduct;
use Modules\Media\Support\Traits\MediaRelation;
use Modules\Iforms\Support\Traits\Formeable;
use Modules\Ifillable\Traits\isFillable;

class Service extends CrudModel
{

  use Translatable, WithProduct, MediaRelation, BelongsToTenant, Formeable, isFillable;

  public $transformer = 'Modules\Ibooking\Transformers\ServiceTransformer';
  public $repository = 'Modules\Ibooking\Repositories\ServiceRepository';
  public $requestValidation = [
    'create' => 'Modules\Ibooking\Http\Requests\CreateServiceRequest',
    'update' => 'Modules\Ibooking\Http\Requests\UpdateServiceRequest',
  ];

  protected $table = 'ibooking__services';
  public $translatedAttributes = ['title', 'description', 'slug'];
  protected $casts = ['options' => 'array'];
  protected $fillable = [
    'price',
    'status',
    'with_meeting',
    'category_id',
    'shift_time',
    'options'
  ];

  public $modelRelations = [
    'categories' => 'belongsToMany',
    'resources' => 'belongsToMany',
  ];

  /**
   * Relation many to many with categories
   * @return mixed
   */
  public function categories()
  {
    return $this->belongsToMany(Category::class, 'ibooking__service_category');
  }

  /**
   * Relation Many to Many with resources
   * @return mixed
   */
  public function resources()
  {
    return $this->belongsToMany(Resource::class, 'ibooking__service_resource');
  }

  public function reservationItems()
  {
    return $this->hasMany(ReservationItem::class);
  }

  public function category()
  {
    return $this->belongsTo(Category::class)->with('translations');
  }

  /*
  * Product - Required shipping
  * Is used in trait WithProduct
  */
  public function getRequiredShippingAttribute(){
    return false;
  }
  
}
