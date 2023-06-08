<?php

namespace Modules\Icommercefreeshipping\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface IcommerceFreeshippingRepository extends BaseRepository
{

    public function calculate($parameters,$conf);
    
}
