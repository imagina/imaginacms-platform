<?php

namespace Modules\Qreable\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface QrRepository extends BaseRepository
{
    /**
     * @param $params
     * @return mixed
     */
    public function getItemsBy($params);

    /**
     * @param $criteria
     * @param $params
     * @return mixed
     */
    public function getItem($criteria, $params = false);
}
