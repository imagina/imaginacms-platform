<?php

namespace Modules\Menu\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface MenuRepository extends BaseRepository
{
    /**
     * Get all online menus
     *
     * @return object
     */
    public function allOnline();

    /**
     * @return mixed
     */
    public function getItem($criteria, $params = false);

    /**
     * @return mixed
     */
    public function updateBy($criteria, $data, $params = false);

    /**
     * @return mixed
     */
    public function getItemsBy($params);

    /**
     * @return mixed
     */
    public function deleteBy($criteria, $params = false);
}
