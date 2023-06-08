<?php

namespace Modules\Icommerceagree\Repositories\Eloquent;

use Modules\Icommerceagree\Repositories\IcommerceAgreeRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentIcommerceAgreeRepository extends EloquentBaseRepository implements IcommerceAgreeRepository
{

    function calculate($parameters,$conf){
         
        $response["status"] = "success";
        
        // Items
        $response["items"] = null;

        // Price
        $response["price"] = 0;
        $response["priceshow"] = false;

        return $response;

    }

}
