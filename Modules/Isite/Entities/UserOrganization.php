<?php

namespace Modules\Isite\Entities;

use Astrotomic\Translatable\Translatable;
use Modules\Core\Icrud\Entities\CrudModel;

class UserOrganization extends CrudModel
{
  use Translatable;

  protected $table = 'isite__user_organization';
  public $transformer = 'Modules\Isite\Transformers\UserOrganizationTransformer';
  public $repository = 'Modules\Isite\Repositories\UserOrganizationRepository';
  public $requestValidation = [
    'create' => 'Modules\Isite\Http\Requests\CreateUserOrganizationRequest',
    'update' => 'Modules\Isite\Http\Requests\UpdateUserOrganizationRequest',
  ];
  public $translatedAttributes = [];
  protected $fillable = [
    'organization_id',
    'user_id',
    'role_id',
    'permissions',
  ];
}
