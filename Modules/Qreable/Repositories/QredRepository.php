<?php

namespace Modules\Qreable\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface QredRepository extends BaseRepository
{
    /**
     * @return mixed
     */
    public function getItem($criteria, $params = false);

    /**
     * @return mixed
     */
    public function getItemsBy($params);
}
