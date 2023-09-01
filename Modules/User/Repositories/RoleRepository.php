<?php

namespace Modules\User\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

/**
 * Interface RoleRepository
 */
interface RoleRepository
{
    /**
     * Return all the roles
     *
     * @return mixed
     */
    public function all();

    /**
     * Create a role resource
     *
     * @return mixed
     */
    public function create($data);

    /**
     * Find a role by its id
     *
     * @return mixed
     */
    public function find($id);

    /**
     * Update a role
     *
     * @return mixed
     */
    public function update($id, $data);

    /**
     * Delete a role
     *
     * @return mixed
     */
    public function delete($id);

    /**
     * Find a role by its name
     *
     * @param  string  $name
     * @return mixed
     */
    public function findByName($name);

    /**
     * Find a role by its slug
     *
     * @param  string  $slug
     * @return mixed
     */
    public function findBySlug($slug);

    /**
     * Paginating, ordering and searching through pages for server side index table
     */
    public function serverPaginationFilteringFor(Request $request): LengthAwarePaginator;
}
