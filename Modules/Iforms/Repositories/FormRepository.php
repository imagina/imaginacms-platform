<?php

namespace Modules\Iforms\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface FormRepository extends BaseRepository
{
    /**
     * List or resources
     * @param $params
     * @return mixed
     */
    public function getItemsBy($params);

    /**
     * find a resource by id or slug
     * @param $criteria
     * @param $params
     * @return mixed
     */
    public function getItem($criteria, $params);

    /**
     * Find by System Name
     * @param $systemName
     * @return mixed
     */
    public function findBySystemName($systemName);

}
