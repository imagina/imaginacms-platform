<?php

namespace Modules\Ihelpers\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BaseApiTransformer extends JsonResource
{
    //Check if field is required in request
    public function ifRequestField($fieldName, $includeName = false)
    {
        $request = request();
        $fields = $request->input('fields') ? explode(',', $request->input('fields')) : false;

        //Check if includeName not is required and request fields
        if (! $this->ifRequestInclude($includeName) && $fields) {
            if (! in_array($fieldName, $fields)) {
                $response = false;
            }
        }

        return $response ?? true;
    }

    //Check if include is required in request
    public function ifRequestInclude($includeName)
    {
        $request = request();
        $include = $request->input('include') ? explode(',', $request->input('include')) : false;

        //Check if includeName is required
        if ($includeName && $include) {
            if (in_array($includeName, $include)) {
                $response = true;
            }
        }

        return $response ?? false;
    }
}
