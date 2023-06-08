<?php

namespace Modules\Iblog\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Core\Icrud\Transformers\CrudResource;
use Modules\User\Transformers\UserProfileTransformer;
use Modules\Media\Image\Imagy;
use Modules\Ifillable\Transformers\FieldTransformer;
use Modules\Isite\Transformers\RevisionTransformer;

class CategoryTransformer extends CrudResource
{
  
  /**
   * Method to merge values with response
   *
   * @return array
   */
  public function modelAttributes($request)
  {
    return [
      'url' => $this->url ?? '#',
      'mainImage' => $this->main_image,
      'secondaryImage' => $this->when($this->secondary_image, $this->secondary_image),
    ];
  }

}
