<?php

namespace Modules\Iforms\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface FieldRepository extends BaseRepository
{
  public function getItemsBy($params);

  public function getItem($criteria, $params);

}
