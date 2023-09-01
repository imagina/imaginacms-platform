<?php

namespace Modules\Icommerceflatrate\Repositories\Eloquent;

use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Modules\Icommerceflatrate\Repositories\IcommerceFlatrateRepository;

class EloquentIcommerceFlatrateRepository extends EloquentBaseRepository implements IcommerceFlatrateRepository
{
    public function calculate($parameters, $conf)
    {
        $response['status'] = 'success';

        // Items
        $response['items'] = null;

        // Price
        $response['price'] = $conf->cost;
        $response['priceshow'] = true;

        return $response;
    }
}
