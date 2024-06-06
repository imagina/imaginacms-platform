<?php

namespace Modules\Menu\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface MenuRepository extends BaseRepository
{
    /**
     * Get all online menus
     * @return object
     */
    public function allOnline();

    /**
     * @param $criteria
     * @param $params
     * @return mixed
     */
    public function getItem($criteria, $params);

    /**
     * @param $criteria
     * @param $data
     * @param $params
     * @return mixed
     */
    public function updateBy($criteria, $data, $params);

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
    public function deleteBy($criteria, $params);

}
