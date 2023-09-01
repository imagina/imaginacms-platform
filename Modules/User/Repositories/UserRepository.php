<?php

namespace Modules\User\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Modules\User\Entities\UserInterface;

/**
 * Interface UserRepository
 */
interface UserRepository
{
    /**
     * Returns all the users
     *
     * @return object
     */
    public function all();

    /**
     * Create a user resource
     *
     * @return mixed
     */
    public function create(array $data);

    /**
     * Create a user and assign roles to it
     *
     * @param  array  $data
     * @param  array  $roles
     * @param  bool  $activated
     */
    public function createWithRoles($data, $roles, $activated = false);

    /**
     * Create a user and assign roles to it
     * But don't fire the user created event
     *
     * @param  array  $data
     * @param  array  $roles
     * @param  bool  $activated
     * @return UserInterface
     */
    public function createWithRolesFromCli($data, $roles, $activated = false);

    /**
     * Find a user by its ID
     *
     * @return mixed
     */
    public function find($id);

    /**
     * Update a user
     *
     * @return mixed
     */
    public function update($user, $data);

    /**
     * Update a user and sync its roles
     *
     * @param  int  $userId
     * @return mixed
     */
    public function updateAndSyncRoles($userId, $data, $roles);

    /**
     * Deletes a user
     *
     * @return mixed
     */
    public function delete($id);

    /**
     * Find a user by its credentials
     *
     * @return mixed
     */
    public function findByCredentials(array $credentials);

    /**
     * Paginating, ordering and searching through pages for server side index table
     */
    public function serverPaginationFilteringFor(Request $request): LengthAwarePaginator;

    public function getItem($criteria, $params = false);
}
