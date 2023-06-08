<?php

namespace Modules\Requestable\Entities;

use Astrotomic\Translatable\Translatable;
use Modules\Core\Icrud\Entities\CrudModel;

class Field extends CrudModel
{

  protected $table = 'requestable__fields';
  public $transformer = 'Modules\Requestable\Transformers\FieldTransformer';
  public $repository = 'Modules\Requestable\Repositories\FieldRepository';
  public $requestValidation = [
    'create' => 'Modules\Requestable\Http\Requests\CreateFieldRequest',
    'update' => 'Modules\Requestable\Http\Requests\UpdateFieldRequest',
  ];

  protected $fillable = [
    'requestable_id',
    'value',
    'name',
    'type'
  ];
}
