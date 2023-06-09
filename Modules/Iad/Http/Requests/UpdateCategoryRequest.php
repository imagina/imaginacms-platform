<?php

namespace Modules\Iad\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;
use Modules\Ihelpers\Rules\UniqueSlugRule;

class UpdateCategoryRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'title' => 'min:2',
            'slug' => [new UniqueSlugRule('iad__category_translations', $this->id, 'category_id'), 'min:2'],
            'description' => 'min:2',
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
        return [];
    }

    public function translationMessages()
    {
        return [
            // title
            'title.required' => trans('iad::common.messages.field required'),
            'title.min:2' => trans('iad::common.messages.min 2 characters'),

            // slug
            'slug.required' => trans('iad::common.messages.field required'),
            'slug.min:2' => trans('iad::common.messages.min 2 characters'),

            // description
            'description.required' => trans('iad::common.messages.field required'),
            'description.min:2' => trans('iad::common.messages.min 2 characters'),
        ];
    }
}
