<?php

namespace Modules\Ilocations\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface PolygonRepository extends BaseRepository
{
  public function getItemsBy($params);
  public function getItem($criteria, $params);
}
