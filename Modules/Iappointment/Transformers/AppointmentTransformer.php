<?php

namespace Modules\Iappointment\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Ichat\Transformers\ConversationTransformer;
use Modules\Iprofile\Transformers\UserTransformer;

class AppointmentTransformer extends JsonResource
{
    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'description' => $this->description ?? '',
            'statusId' => (string) $this->status_id,
            'categoryId' => $this->category_id,
            'customerId' => $this->customer_id,
            'assignedTo' => $this->assigned_to,
            'options' => $this->options,
            'createdAt' => $this->when($this->created_at, $this->created_at),
            'updatedAt' => $this->when($this->updated_at, $this->updated_at),
            'options' => $this->options,
            'category' => new CategoryTransformer($this->whenLoaded('category')),
            'status' => new AppointmentStatusTransformer($this->whenLoaded('status')),
            'fields' => AppointmentLeadTransformer::collection($this->whenLoaded('fields')),
            'customer' => new UserTransformer($this->whenLoaded('customer')),
            'assigned' => new UserTransformer($this->whenLoaded('assigned')),
        ];

        if (is_module_enabled('Ichat')) {
            $data['conversation'] = new ConversationTransformer($this->whenLoaded('conversation'));
        }

        $filter = json_decode($request->filter);

        // Return data with available translations
        if (isset($filter->allTranslations) && $filter->allTranslations) {
            // Get langs avaliables
            $languages = \LaravelLocalization::getSupportedLocales();

            foreach ($languages as $lang => $value) {
                $data[$lang]['description'] = $this->hasTranslation($lang) ?
                    $this->translate("$lang")['description'] ?? '' : '';
            }
        }

        return $data;
    }
}
