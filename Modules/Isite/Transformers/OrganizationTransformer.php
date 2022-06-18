<?php

namespace Modules\Isite\Transformers;

use Modules\Core\Icrud\Transformers\CrudResource;

class OrganizationTransformer extends CrudResource
{
  /**
  * Method to merge values with response
  *
  * @return array
  */
  public function modelAttributes($request)
  {

    return [
      "url" => $this->url,
      'status' => $this->status ? '1' : '0',
      'featured' => $this->featured ? '1' : '0'
    ];
  }
}
