<?php

if (!function_exists('createOrUpdateRole')) {
    function createOrUpdateRole(array $role)
    {
        $profileRoleRepository = app("Modules\Iprofile\Repositories\RoleApiRepository");

        // Search Role
        $params = ["filter" => ["field" => "slug"],"include" => [],"fields" => []];
        $existRole = $profileRoleRepository->getItem($role['slug'], json_decode(json_encode($params)));

        //Create / Update
        if (!isset($existRole->id))
            $result = $profileRoleRepository->create($role);
        else
            $result = $profileRoleRepository ->updateBy($existRole->id,$role);
        
        return $result;
    }
}
