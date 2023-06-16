<?php

namespace Modules\Icommercepaypal\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface IcommercePaypalRepository extends BaseRepository
{
    public function calculate($parameters, $conf);
}
