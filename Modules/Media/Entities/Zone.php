<?php

namespace Modules\Media\Entities;

use Astrotomic\Translatable\Translatable;
use Modules\Core\Icrud\Entities\CrudModel;
use Modules\Media\Support\Traits\MediaRelation;

class Zone extends CrudModel
{
  use MediaRelation;
  
  protected $table = 'media__zones';
  public $transformer = 'Modules\Media\Transformers\ZoneTransformer';
  public $requestValidation = [
    'create' => 'Modules\Media\Http\Requests\CreateZoneRequest',
    'update' => 'Modules\Media\Http\Requests\UpdateZoneRequest',
  ];
  
  protected $fillable = [
    
    "parent_entity_type",
    "parent_entity_id",
    "entity_type",
    "entity_id",
    "name",
    "options",
  ];
  
  protected $casts = [
    'options' => 'object'
  ];
}
