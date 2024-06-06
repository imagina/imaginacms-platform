<?php

namespace Modules\Iblog\Repositories;

use Modules\Core\Repositories\BaseRepository;

/**
 * Interface PostRepository
 * @package Modules\Iblog\Repositories
 */
interface PostRepository extends BaseRepository
{

    /**
     * Get the next post of the given post
     * @param object $id
     * @return object
     */

    public function WhereCategory($id);

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
    public function getItem($criteria, $params);


}
