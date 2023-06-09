<?php

namespace Modules\Icommercecoordinadora\Repositories\Eloquent;

use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Modules\Icommercecoordinadora\Repositories\IcommerceCoordinadoraRepository;

class EloquentIcommerceCoordinadoraRepository extends EloquentBaseRepository implements IcommerceCoordinadoraRepository
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
