<?php

namespace Modules\Iblog\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;
use Modules\Ihelpers\Rules\UniqueSlugRule;

class UpdateCategoryRequest extends BaseFormRequest
{
    public function rules()
    {
        return [];
    }

    public function translationRules()
    {
        return [
            'title' => 'min:1',
            'slug' => [new UniqueSlugRule('iblog__category_translations', $this->id, 'category_id', trans('iblog::category.messages.sameSlug')), 'min:1'],
            'description' => 'min:1',
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
            'title.required' => trans('iblog::common.messages.field required'),
            'title.min:1' => trans('iblog::common.messages.min 2 characters'),

            // slug
            'slug.required' => trans('iblog::common.messages.field required'),
            'slug.min:1' => trans('iblog::common.messages.min 2 characters'),

            // description
            'description.required' => trans('iblog::common.messages.field required'),
            'description.min:1' => trans('iblog::common.messages.min 2 characters'),
        ];
    }

    public function getValidator()
    {
        return $this->getValidatorInstance();
    }
}
