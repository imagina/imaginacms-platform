<?php

namespace Modules\Iplan\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class UpdatePlanRequest extends BaseFormRequest
{
  public function rules()
  {
    return [
    
      //"frequency_id" => "required|numeric|min:1",
     // "category_id" => "required|numeric|min:0",
    ];
  }
  
  public function translationRules()
  {
    return [
     // "name" => "required|string|max:100",
    //  "description" => "string|max:1000",
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
    return [];
  }
  
  public function getValidator()
  {
    return $this->getValidatorInstance();
  }
}
