<?php

namespace Modules\Icredit\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;
use Modules\Ihelpers\Rules\UniqueSlugRule;

class UpdateCreditRequest extends BaseFormRequest
{
    public function rules()
    {
        return [];
    }

    public function translationRules()
    {

        return [
            'title' => 'min:2',
            'slug' => [new UniqueSlugRule("icredit__credit_translations", $this->id, "credit_id") ,"min:2"],
            'description' => 'min:2',
        ];
    }

    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [];
    }

    public function translationMessages()
    {
        return [
            // title
            'title.required' => trans('icredit::common.messages.field required'),
            'title.min:2' => trans('icredit::common.messages.min 2 characters'),

            // slug
            'slug.required' => trans('icredit::common.messages.field required'),
            'slug.min:2' => trans('icredit::common.messages.min 2 characters'),

            // description
            'description.required' => trans('icredit::common.messages.field required'),
            'description.min:2' => trans('icredit::common.messages.min 2 characters'),
        ];
    }

    public function getValidator(){
        return $this->getValidatorInstance();
    }
}