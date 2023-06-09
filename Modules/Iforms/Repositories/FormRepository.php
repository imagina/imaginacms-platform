<?php

namespace Modules\Iforms\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface FormRepository extends BaseRepository
{
    /**
     * List or resources
     *
     * @return mixed
     */
    public function getItemsBy($params);

    /**
     * find a resource by id or slug
     *
     * @return mixed
     */
    public function getItem($criteria, $params = false);

    /**
     * Find by System Name
     *
     * @return mixed
     */
    public function findBySystemName($systemName);
}
