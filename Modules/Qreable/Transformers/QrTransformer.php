<?php

namespace Modules\Qreable\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class QrTransformer extends JsonResource
{
    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'code' => $this->when($this->code, $this->code),
            'zone' => $this->pivot->zone ?? '',
            'redirect' => $this->pivot->redirect ?? '',
            'qredId' => $this->pivot->id ?? '',
        ];

        return $data;
    }
}
