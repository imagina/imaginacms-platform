<?php

namespace Modules\Notification\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class CreateNotificationRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'title' => 'required|min:2',
            'message' => 'required|min:2',
            'icon_class' => 'required|min:2',
            'link' => 'required|min:2',
            'type' => 'required',
            'to' => 'required',
        ];
    }

    public function translationRules()
    {
        return [

        ];
    }

    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [
            'title.required' => trans('notification::messages.validations.required.title'),
            'title.min:2' => trans('notification::messages.validations.min2.title'),
            'message.required' => trans('notification::messages.validations.required.message'),
            'message.min:2' => trans('notification::messages.validations.min2.message'),
            'icon_class.required' => trans('notification::messages.validations.required.icon_class'),
            'icon_class.min:2' => trans('notification::messages.validations.min2.icon_class'),
            'link.required' => trans('notification::messages.validations.required.link'),
            'link.min:2' => trans('notification::messages.validations.min2.link'),
            'type.required' => trans('notification::messages.validations.required.type'),
            'to.required' => trans('notification::messages.validations.required.to'),

        ];
    }

    public function translationMessages()
    {
        return [

        ];
    }
}
