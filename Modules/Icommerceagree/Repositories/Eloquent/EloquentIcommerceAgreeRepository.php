<?php

namespace Modules\Icommerceagree\Repositories\Eloquent;

use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Modules\Icommerceagree\Repositories\IcommerceAgreeRepository;

class EloquentIcommerceAgreeRepository extends EloquentBaseRepository implements IcommerceAgreeRepository
{
    public function calculate($parameters, $conf)
    {
        $response['status'] = 'success';

        // Items
        $response['items'] = null;

        // Price
        $response['price'] = 0;
        $response['priceshow'] = false;

        return $response;
    }
}
