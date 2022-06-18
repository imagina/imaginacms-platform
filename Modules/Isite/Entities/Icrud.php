<?php

namespace Modules\Isite\Entities;

use Modules\Core\Icrud\Entities\CrudModel;

class Icrud extends CrudModel
{
  protected $table = 'isite__icruds';
  public $transformer = 'Modules\Isite\Transformers\IcrudTransformer';
  public $requestValidation = [
    'create' => 'Modules\Isite\Http\Requests\CreateIcrudRequest',
    'update' => 'Modules\Isite\Http\Requests\UpdateIcrudRequest',
  ];
  protected $fillable = ['module', 'entity', 'main_crud', 'project_crud'];
  protected $casts = ['main_crud' => 'object', 'project_crud' => 'object'];
}
