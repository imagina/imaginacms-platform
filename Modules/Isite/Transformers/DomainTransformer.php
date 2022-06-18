<?php

namespace Modules\Isite\Transformers;

use Modules\Core\Icrud\Transformers\CrudResource;

class DomainTransformer extends CrudResource
{
  /**
  * Method to merge values with response
  *
  * @return array
  */
  public function modelAttributes($request)
  {
    return [];
  }
}
