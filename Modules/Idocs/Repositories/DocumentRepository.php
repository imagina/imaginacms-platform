<?php

namespace Modules\Idocs\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface DocumentRepository extends BaseRepository
{
    /**
     * @return mixed
     */
    public function getItemsBy($params);

    /**
     * @return mixed
     */
    public function getItem($criteria, $params = false);

    /**
     * @return mixed
     */
    public function whereCategory($id);
}
