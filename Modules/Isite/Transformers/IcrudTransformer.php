<?php

namespace Modules\Isite\Transformers;

use Modules\Core\Icrud\Transformers\CrudResource;

class IcrudTransformer extends CrudResource
{
    /**
     * Method to merge values with response
     */
    public function modelAttributes($request)
    {
        $filter = json_decode($request->filter); //Get request Filters
        //Validate if translate labels of crud
        $translateCrud = (isset($filter->noTranslate) && $filter->noTranslate) ? false : true;

        //Response
        return [
            'projectCrud' => $translateCrud ? $this->translateCrudLabels($this->project_crud) : $this->project_crud,
            'mainCrud' => $translateCrud ? $this->translateCrudLabels($this->main_crud) : $this->main_crud,
        ];
    }

    //Recursive Translate labels
    public function translateCrudLabels($data)
    {
        foreach ($data as $key => &$item) {
            if (is_string($item)) {
                $item = trans($item);
            } elseif (is_array($item) || is_object($item)) {
                $item = $this->translateCrudLabels($item);
            }
        }

        //Response
        return $data;
    }
}
