<?php

namespace Modules\Requestable\Transformers;

use Modules\Core\Icrud\Transformers\CrudResource;

class CategoryRuleTransformer extends CrudResource
{
    /**
     * Method to merge values with response
     */
    public function modelAttributes($request): array
    {
        $data = [
            'statusName' => $this->statusName,
            'formFields' => $this->form_fields,
        ];

        //getting filter from the request
        $filter = (is_string($request->input('filter')) ? json_decode($request->input('filter')) : json_decode(json_encode($request->input('filter'))));

        //Translate the labels of the formfields
        if (! is_null($this->form_fields)) {
            foreach ($this->form_fields as $name => $field) {
                //if the field is expression and the filter categoryId is coming in the request it'll be replaced in the field
                if (isset($field->type) && $field->type == 'expression' && isset($filter->categoryId) && ! empty($filter->categoryId)) {
                    $data['formFields']->$name->loadOptions->parametersUrl->categoryId = $filter->categoryId;
                }

                if (isset($data['formFields']->$name->props->label)) {
                    $data['formFields']->$name->props->label = trans($data['formFields']->$name->props->label);
                }
            }
        }

        //Response
        return $data;
    }
}
