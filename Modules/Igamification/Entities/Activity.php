<?php

namespace Modules\Igamification\Entities;

use Astrotomic\Translatable\Translatable;
use Modules\Core\Icrud\Entities\CrudModel;
use Modules\Igamification\Entities\Category;

use Modules\Igamification\Entities\Status;
use Modules\Igamification\Entities\Type;
use Modules\Media\Support\Traits\MediaRelation;
use Modules\Iforms\Support\Traits\Formeable;

class Activity extends CrudModel
{
  use Translatable, MediaRelation, Formeable;

  protected $table = 'igamification__activities';
  public $transformer = 'Modules\Igamification\Transformers\ActivityTransformer';
  public $repository = 'Modules\Igamification\Repositories\ActivityRepository';
  public $requestValidation = [
    'create' => 'Modules\Igamification\Http\Requests\CreateActivityRequest',
    'update' => 'Modules\Igamification\Http\Requests\UpdateActivityRequest',
  ];
  public $translatedAttributes = ['title', 'description'];
  protected $fillable = [
    'system_name',
    'status',
    'url',
    'category_id',
    'type',
    'options',
    'position'
  ];

  protected $casts = [
    'options' => 'array'
  ];

  public $modelRelations = [
    'categories' => 'belongsToMany',
  ];

  //============== RELATIONS ==============//
  public function categories()
  {
    return $this->belongsToMany(Category::class, 'igamification__activity_category');
  }

  public function category()
  {
    return $this->belongsTo(Category::class);
  }

  public function users()
  {
    $driver = config('asgard.user.config.driver');

    return $this->belongsToMany("Modules\\User\\Entities\\{$driver}\\User", 'igamification__activity_user');
  }

  //============== MUTATORS / ACCESORS ==============//

  public function setOptionsAttribute($value)
  {
    $this->attributes['options'] = json_encode($value);
  }

  public function getOptionsAttribute($value)
  {
    return json_decode($value);
  }

  public function getStatusNameAttribute()
  {
    $status = new Status();
    return $status->get($this->status);
  }

  public function getTypeNameAttribute()
  {
    $typeClass = new Type();
    $type = $typeClass->get($this->type);
    return $type["title"];
  }

}
