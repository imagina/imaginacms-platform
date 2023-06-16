<?php

namespace Modules\Qreable\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface QrRepository extends BaseRepository
{
    /**
     * @return mixed
     */
    public function getItemsBy($params);

    /**
     * @return mixed
     */
    public function getItem($criteria, $params = false);
}
