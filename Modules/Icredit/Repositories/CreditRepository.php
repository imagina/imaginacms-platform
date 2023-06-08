<?php

namespace Modules\Icredit\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface CreditRepository extends BaseRepository
{

    public function calculate($parameters,$conf);
    
    //public function amount($params);
    
}
