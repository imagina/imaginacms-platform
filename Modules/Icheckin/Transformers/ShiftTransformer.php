<?php

namespace Modules\Icheckin\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Iprofile\Transformers\UserTransformer;

class ShiftTransformer extends JsonResource
{
    public function toArray($request)
    {
        $date1 = new \DateTime($this->checkout_at ? $this->checkout_at : date('Y-m-d H:i:s'));
        $date2 = new \DateTime($this->checkin_at);
        $diff = $date1->diff($date2);
        $item = [
            'id' => $this->when($this->id, $this->id),
            'checkinAt' => $this->when($this->checkin_at, $this->checkin_at),
            'checkoutAt' => $this->when($this->checkout_at, $this->checkout_at),
            'now' => date('Y-m-d H:i:s'),
            'diff' => $diff,
            'geoLocation' => $this->geo_location,
            'requestId' => $this->when($this->request_id, $this->request_id),
            'options' => $this->when($this->options, $this->options),
            'jobId' => $this->when($this->job_id, $this->job_id),
            'checkinBy' => new UserTransformer($this->whenLoaded('checkinBy')),
            'checkoutBy' => new UserTransformer($this->whenLoaded('checkoutBy')),
        ];

        return $item;
    }
}
