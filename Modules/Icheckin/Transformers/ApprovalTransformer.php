<?php

namespace Modules\Icheckin\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class ApprovalTransformer extends JsonResource
{
    public function toArray($request)
    {
        $item = [

            'id' => $this->id,
            'dateForApprove' => $this->date,
            'userId' => $this->user_id,
            'approvedById' => $this->approved_by,
            'periodApproved' => $this->period_approved,
            'hoursApproved' => $this->period_approved / 3600,

        ];

        return $item;
    }
}
