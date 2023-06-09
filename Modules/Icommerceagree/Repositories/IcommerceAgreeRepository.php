<?php

namespace Modules\Icommerceagree\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface IcommerceAgreeRepository extends BaseRepository
{
    public function calculate($parameters, $conf);
}
