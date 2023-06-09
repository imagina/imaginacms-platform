<?php

namespace Modules\Requestable\Transformers;

use Modules\Core\Icrud\Transformers\CrudResource;
use Modules\Media\Transformers\NewTransformers\MediaTransformer;

class RequestableTransformer extends CrudResource
{
    /**
     * Method to merge values with response
     *
     * @return array
     */
    public function modelAttributes($request)
    {
        if (! empty($this->requestable_type) && ! empty($this->requestable_id)) {
            $model = $this->requestable_type::find($this->requestable_id);
        }

        return [
            'requestableUrl' => isset($model->url) ? $model->url : '',
            'statusValue' => isset($this->status) ? $this->status->value : null,
            'files' => MediaTransformer::collection($this->whenLoaded('files')),
            'comment' => null,
        ];
    }
}
