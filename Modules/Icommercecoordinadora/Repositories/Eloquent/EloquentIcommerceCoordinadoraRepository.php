<?php

namespace Modules\Icommercecoordinadora\Repositories\Eloquent;

use Modules\Icommercecoordinadora\Repositories\IcommerceCoordinadoraRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentIcommerceCoordinadoraRepository extends EloquentBaseRepository implements IcommerceCoordinadoraRepository
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
