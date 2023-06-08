<?php

namespace Modules\Iblog\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Core\Icrud\Transformers\CrudResource;
use Modules\Tag\Transformers\TagTransformer;
use Modules\User\Transformers\UserProfileTransformer;
use Modules\Iblog\Entities\Post;
use Illuminate\Support\Arr;
use  Modules\Isite\Transformers\RevisionTransformer;

class PostTransformer extends CrudResource
{
  /**
   * Method to merge values with response
   *
   * @return array
   */
  public function modelAttributes($request)
  {
    return [
      'statusName' => $this->when($this->status, $this->present()->status),
      'url' => $this->url ?? '#',
      'mainImage' => $this->main_image,
      'secondaryImage' => $this->when($this->secondary_image, $this->secondary_image),
      'gallery' => $this->gallery,
      'editor' => new UserProfileTransformer($this->whenLoaded('user')),
    ];
  }
}
