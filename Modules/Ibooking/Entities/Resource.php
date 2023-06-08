<?php

namespace Modules\Ibooking\Entities;

use Astrotomic\Translatable\Translatable;
use Modules\Core\Icrud\Entities\CrudModel;
use Modules\Ibooking\Entities\Service;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

//Traits
use Modules\Ischedulable\Support\Traits\Schedulable;
use Modules\Media\Support\Traits\MediaRelation;

use Modules\Imeeting\Traits\Meetingable;

class Resource extends CrudModel
{
  use Translatable, Schedulable, MediaRelation, Meetingable, BelongsToTenant;

  public $transformer = 'Modules\Ibooking\Transformers\ResourceTransformer';
  public $repository = 'Modules\Ibooking\Repositories\ResourceRepository';
  public $requestValidation = [
    'create' => 'Modules\Ibooking\Http\Requests\CreateResourceRequest',
    'update' => 'Modules\Ibooking\Http\Requests\UpdateResourceRequest',
  ];
  protected $table = 'ibooking__resources';
  public $translatedAttributes = ['title', 'description', 'slug'];
  protected $casts = ['options' => 'array'];
  protected $fillable = [
    'status',
    'options'
  ];

  public $modelRelations = [
    'assignedTo' => 'belongsTo',
    'services' => 'belongsToMany',
  ];

  public $dispatchesEventsWithBindings = [
    'created' => [
      [
        'path' => 'Modules\Igamification\Events\ActivityWasCompleted',
        'extraData' => ['systemNameActivity' => 'availability-organize']
      ]
    ]
  ];

  /**
   * Relation many to many with services
   * @return mixed
   */
  public function services()
  {
    return $this->belongsToMany(Service::class, 'ibooking__service_resource');
  }

  /*
  * Accessors
  */
  public function getOptionsAttribute($value)
  {
    return json_decode($value);
  }

  /*
  * Mutators
  */
  public function setOptionsAttribute($value)
  {
    $this->attributes['options'] = json_encode($value);
  }
  
}
