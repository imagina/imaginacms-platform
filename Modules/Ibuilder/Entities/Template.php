<?php

namespace Modules\Ibuilder\Entities;

use Astrotomic\Translatable\Translatable;
use Modules\Core\Icrud\Entities\CrudModel;

class Template extends CrudModel
{
  use Translatable;

  protected $table = 'ibuilder__templates';
  public $transformer = 'Modules\Ibuilder\Transformers\TemplateTransformer';
  public $requestValidation = [
      'create' => 'Modules\Ibuilder\Http\Requests\CreateTemplateRequest',
      'update' => 'Modules\Ibuilder\Http\Requests\UpdateTemplateRequest',
    ];
  //Instance external/internal events to dispatch with extraData
  public $dispatchesEventsWithBindings = [
    //eg. ['path' => 'path/module/event', 'extraData' => [/*...optional*/]]
    'created' => [],
    'creating' => [],
    'updated' => [],
    'updating' => [],
    'deleting' => [],
    'deleted' => []
  ];
  public $translatedAttributes = [];
  protected $fillable = [];
}
