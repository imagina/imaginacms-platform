<?php

namespace Modules\Iappointment\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Iprofile\Transformers\UserTransformer;

class AppointmentStatusHistoryTransformer extends JsonResource
{
    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'comment' => $this->comment ?? '',
            'assignedTo' => (int) $this->assigned_to,
            'appointmentId' => (int) $this->appointment_id,
            'assigned' => new UserTransformer($this->whenLoaded('assigned')),
            'appointment' => new AppointmentTransformer($this->whenLoaded('appointment')),
            'createdAt' => $this->when($this->created_at, $this->created_at),
            'updatedAt' => $this->when($this->updated_at, $this->updated_at),
        ];

        $filter = json_decode($request->filter);

        // Return data with available translations
        if (isset($filter->allTranslations) && $filter->allTranslations) {
            // Get langs avaliables
            $languages = \LaravelLocalization::getSupportedLocales();

            foreach ($languages as $lang => $value) {
                $data[$lang]['comment'] = $this->hasTranslation($lang) ?
                    $this->translate("$lang")['comment'] : '';
            }
        }

        return $data;
    }
}
