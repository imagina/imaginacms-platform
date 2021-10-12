<?php

namespace Modules\Media\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class CreateZoneRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
          "name" => 'required',
          "entity_type" => 'required'
        ];
    }

    public function translationRules()
    {
        return [];
    }

    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [
          'name.required' => trans('media::zones.messages.nameRequired'),
          'entity_type.required' => trans('media::zones.messages.entityTypeRequired'),
        ];
    }

    public function translationMessages()
    {
        return [];
    }
}
