<?php

namespace Modules\Iblog\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;
use Modules\Ihelpers\Rules\UniqueSlugRule;

class UpdatePostRequest extends BaseFormRequest
{
  public function rules()
  {
    return [
      //'category_id' => 'required',
    ];
  }

  public function translationRules()
  {
    return [
      'name' => 'min:1',
      'slug' => [new UniqueSlugRule("iblog__post_translations", $this->id, "post_id") ,"min:1"],
      'description' => 'min:1'
    ];
  }

  public function authorize()
  {
    return true;
  }

  public function messages()
  {
    return [

    ];
  }

  public function translationMessages()
  {
    return [
      // title
      'name.required' => trans('icommerce::common.messages.field required'),
      'name.min:1' => trans('icommerce::common.messages.min 2 characters'),

      // slug
      'slug.required' => trans('icommerce::common.messages.field required'),
      'slug.min:1' => trans('icommerce::common.messages.min 2 characters'),

      // description
      'description.required' => trans('icommerce::common.messages.field required'),
      'description.min:1' => trans('icommerce::common.messages.min 2 characters'),
    ];
  }
}
