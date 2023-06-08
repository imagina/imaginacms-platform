<?php

namespace Modules\Icommerceflatrate\Repositories\Eloquent;

use Modules\Icommerceflatrate\Repositories\IcommerceFlatrateRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentIcommerceFlatrateRepository extends EloquentBaseRepository implements IcommerceFlatrateRepository
{

    function calculate($parameters,$conf){
         
        $response["status"] = "success";
        
        // Items
        $response["items"] = null;

        // Price
        $response["price"] = $conf->cost;
        $response["priceshow"] = true;

        return $response;

    }


}
