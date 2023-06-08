<?php

namespace Modules\Requestable\Entities;

use Astrotomic\Translatable\Translatable;
use Modules\Core\Icrud\Entities\CrudModel;

class Status extends CrudModel
{
  use Translatable;

  protected $table = 'requestable__statuses';
  public $transformer = 'Modules\Requestable\Transformers\StatusTransformer';
  public $repository = 'Modules\Requestable\Repositories\StatusRepository';
  public $requestValidation = [
    'create' => 'Modules\Requestable\Http\Requests\CreateStatusRequest',
    'update' => 'Modules\Requestable\Http\Requests\UpdateStatusRequest',
  ];
  public $translatedAttributes = [
    'title'
  ];
  protected $fillable = [
    'value',
    'category_id',
    'events',
    'color',
    'position',
    'final',
    'default',
    'cancelled_elapsed_time',
    'delete_request'
  ];

  protected $fakeColumns = ['events'];
  protected $with = ['translations'];
  

  protected $casts = [
    'events' => 'array'
  ];

  public function setDefaultAttribute($value){
    //If default is 1 (Create or Update)
    if($value){
      //Change any other status that is 'default' for this category
      Status::where("default",true)->where("category_id",$this->category_id)->update(["default" => false]);
    }
    $this->attributes['default'] = $value;
  }

  public function category()
  {
    return $this->belongsTo(Category::class);
  }
  public function requests()
  {
    return $this->hasMany(Requestable::class);
  }
  public function data()
  {
    return $this->hasMany(Requestable::class);
  }

  public function automationRules()
  {
    return $this->hasMany(AutomationRule::class);
  }

}
