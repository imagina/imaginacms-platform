<?php

namespace Modules\Igamification\Transformers;

use Modules\Core\Icrud\Transformers\CrudResource;

class CategoryTransformer extends CrudResource
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
