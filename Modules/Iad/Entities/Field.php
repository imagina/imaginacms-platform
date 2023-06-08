<?php

namespace Modules\Iad\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Icrud\Entities\CrudModel;

class Field extends CrudModel
{
  public $transformer = 'Modules\Iad\Transformers\FieldTransformer';
  public $entity = 'Modules\Iad\Entities\Field';
  public $repository = 'Modules\Iad\Repositories\FieldRepository';
  public $requestValidation = [
    'create' => 'Modules\Iad\Http\Requests\CreateFieldRequest',
    'update' => 'Modules\Iad\Http\Requests\UpdateFieldRequest',
  ];
  protected $table = 'iad__fields';
  public $translatedAttributes = [];
  protected $fillable = [
    'name',
    'ad_id',
    'value',
    'type'
  ];
  protected $fakeColumns = ['value'];
}
