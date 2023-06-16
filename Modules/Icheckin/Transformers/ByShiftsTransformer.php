<?php

namespace Modules\Icheckin\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Icheckin\Entities\Approvals;
use Modules\Iprofile\Transformers\UserTransformer;
use Modules\User\Entities\Sentinel\User;

class ByShiftsTransformer extends JsonResource
{
    public function toArray($request)
    {
        if ($this->approval_id) {
            $approval = Approvals::find($this->approval_id);
        }

        $hoursElapsed = round($this->total_period_elapsed / 3600, 2);
        $hoursApproved = round($this->period_approved / 3600, 2);

        $item = [
            'ApprovalId' => $this->approval_id,
            'date' => $this->date_for_approve,
            'userId' => $this->checkin_by,
            'approvedById' => $this->approved_by,
            'shifts' => $this->shifts,
            'totalPeriodElapsed' => $this->total_period_elapsed,
            'approved' => $this->approved,
            'periodApproved' => $this->period_approved,
            'hoursElapsed' => $hoursElapsed,
            'hoursApproved' => $hoursApproved,
            'user' => new UserTransformer(User::find($this->checkin_by)),
            'approval' => $approval ?? null,
        ];

        if (isset($approval->id)) {
            $item['approvedBy'] = new UserTransformer($approval->approvedBy);
        }

        return $item;
    }
}
