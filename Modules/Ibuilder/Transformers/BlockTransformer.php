<?php

namespace Modules\Ibuilder\Transformers;

use Modules\Core\Icrud\Transformers\CrudResource;

class BlockTransformer extends CrudResource
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
