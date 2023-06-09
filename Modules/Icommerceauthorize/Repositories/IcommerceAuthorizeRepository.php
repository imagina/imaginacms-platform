<?php

namespace Modules\Icommerceauthorize\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface IcommerceAuthorizeRepository extends BaseRepository
{
    public function calculate($parameters, $conf);

    public function decriptUrl($eUrl);
}
