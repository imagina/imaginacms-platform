<?php


namespace Modules\Iplaces\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Iplaces\Entities\Status;

class SpaceTransformer extends JsonResource
{

    public function toArray($request)
    {
      
        $status = new Status();

        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'status'=>$this->status,
            'statusName' => $status->get($this->status),
            'description' => $this->description,
            'mainImage' => $this->main_image,
            'metaTitle'=>$this->meta_title??$this->title,
            'metaDescription'=>$this->meta_description,
            'metaKeywords'=>$this->meta_keywords,
            'options' => $options,
            'createdAt' => ($this->created_at),
            'updatedAt' => ($this->updated_at)
        ];

    }


}