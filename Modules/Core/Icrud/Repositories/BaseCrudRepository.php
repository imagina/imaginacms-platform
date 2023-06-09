<?php

namespace Modules\Core\Icrud\Repositories;

use Modules\Core\Repositories\BaseRepository;

/**
 * Interface Core Crud Repository
 */
interface BaseCrudRepository extends BaseRepository
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
    public function create($data);

    /**
     * @return mixed
     */
    public function updateBy($criteria, $data, $params = false);

    /**
     * @return mixed
     */
    public function deleteBy($criteria, $params = false);

    /**
     * @return mixed
     */
    public function restoreBy($criteria, $params = false);
}
