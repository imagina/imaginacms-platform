<?php


namespace Modules\Iplaces\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\User\Transformers\UserProfileTransformer;
use Modules\Iplaces\Events\ServiceWasCreated;
use Modules\Iplaces\Entities\Servtype;

class ServiceTransformer extends JsonResource
{

    public function toArray($request)
    {

        $servtype = new Servtype();
      
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'status'=>$this->status,
            'description' => $this->description,
            'type' => $this->servtype,
            'typeName' => $servtype->get($this->serv_type),
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