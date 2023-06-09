<?php

namespace Modules\Ichat\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface UserRepository extends BaseRepository
{
    public function getItemsBy($params);

    public function getItem($criteria, $params = false);
}
