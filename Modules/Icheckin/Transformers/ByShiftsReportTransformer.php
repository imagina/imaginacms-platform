<?php

namespace Modules\Icheckin\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Iprofile\Transformers\UserTransformer;
use Modules\User\Entities\Sentinel\User;

class ByShiftsReportTransformer extends JsonResource
{
    public function toArray($request)
    {
        $hoursElapsed = round($this->total_period_elapsed / 3600, 2);
        $hoursApproved = round($this->period_approved / 3600, 2);
        $user = new UserTransformer(User::find($this->checkin_by));

        $item = [
            'Agent' => $user->present()->fullName,
            'Shifts' => $this->shifts ?? 0,

            'Reported Hours' => $hoursElapsed ?? 0,
            'Approved Hours' => $hoursApproved ?? 0,

        ];

        return $item;
    }
}
