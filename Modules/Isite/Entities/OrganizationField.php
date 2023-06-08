<?php

namespace Modules\Isite\Entities;

use Astrotomic\Translatable\Translatable;
use Modules\Core\Icrud\Entities\CrudModel;

class OrganizationField extends CrudModel
{

  protected $table = 'isite__organization_fields';
  public $transformer = 'Modules\Isite\Transformers\OrganizationFieldTransformer';
  public $repository = 'Modules\Isite\Repositories\OrganizationFieldRepository';
  public $requestValidation = [
    'create' => 'Modules\Isite\Http\Requests\CreateOrganizationFieldRequest',
    'update' => 'Modules\Isite\Http\Requests\UpdateOrganizationFieldRequest',
  ];

  protected $fillable = [
    'organization_id',
    'value',
    'name',
    'type'
  ];
}
