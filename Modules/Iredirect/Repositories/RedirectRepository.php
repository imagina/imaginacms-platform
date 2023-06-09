<?php

namespace Modules\Iredirect\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface RedirectRepository extends BaseRepository
{
    /**
     * Get the next redirect of the given redirect
     *
     * @param  object  $id
     * @return object
     */
    public function find($id);

    /**
     * Get the next redirect of the given redirect
     *
     * @param  object  $slug
     * @return object
     */
    public function findBySlug($slug);

    public function getItemsBy($params);

    public function getItem($criteria, $params = false);

    public function create($data);

    public function updateBy($criteria, $data, $params = false);

    public function deleteBy($criteria, $params = false);
}
