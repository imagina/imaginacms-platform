<?php

namespace Modules\Icommercecredibanco\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface IcommerceCredibancoRepository extends BaseRepository
{
    public function calculate($parameters, $conf);
}
