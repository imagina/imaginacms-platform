<?php

namespace Modules\Idocs\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface DocumentRepository extends BaseRepository
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

    /**
     * @param $id
     * @return mixed
     */
    public function whereCategory($id);
}
