<?php

namespace Modules\Qreable\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface QredRepository extends BaseRepository
{

  /**
   * @param $criteria
   * @param $params
   * @return mixed
   */
  public function getItem($criteria, $params = false);

  /**
   * @param $params
   * @return mixed
   */
  public function getItemsBy($params);
}
