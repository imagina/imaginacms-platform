<?php

namespace Modules\Iplaces\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface SpaceRepository extends BaseRepository
{

    public function getItemsBy($params);

      public function getItem($criteria, $params = false);

      public function updateBy($criteria, $data, $params = false);

      public function deleteBy($criteria, $params = false);
}
