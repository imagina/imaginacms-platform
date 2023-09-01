<?php

namespace Modules\Iforms\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class CreateLeadRequest extends BaseFormRequest
{
    public function rules()
    {
        $captcha = setting('isite::activateCaptcha');
        if ($captcha && $captcha == '1') {
            return [
                'g-recaptcha-response' => 'required|icaptcha',
            ];
        }

        return [];
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
            'g-recaptcha-response.required' => trans('iforms::common.messages.captcha_required'),
            'g-recaptcha-response.icaptcha' => trans('iforms::common.messages.captcha_invalid'),
        ];
    }

    public function translationMessages()
    {
        return [];
    }
}
