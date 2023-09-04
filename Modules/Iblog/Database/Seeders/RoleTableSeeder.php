<?php

namespace Modules\Iblog\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use Modules\Isite\Jobs\ProcessSeeds;

class RoleTableSeeder extends Seeder
{
    public function run()
    {
        Model::unguard();
        $rolesId = [];

        //Roles
        $roles = [
            [
                'name' => 'Editor',
                'slug' => 'editor',
        'en' => ['title' => trans("iprofile::roles.types.editor",[],"en")],
        'es' => ['title' => trans("iprofile::roles.types.editor",[],"es")],
        'permissions' => [
                    'profile.api.login' => true,
                    'profile.user.index' => true,
                    'iblog.categories.manage' => true,
                    'iblog.categories.index' => true,
                    'iblog.categories.create' => true,
                    'iblog.categories.edit' => true,
                    'iblog.categories.destroy' => true,
                    'iblog.posts.manage' => true,
                    'iblog.posts.index' => true,
                    'iblog.posts.create' => true,
                    'iblog.posts.edit' => true,
                    'iblog.posts.destroy' => true,
        ]
            ],
            [
                'name' => 'Author',
                'slug' => 'author',
        'en' => ['title' => trans("iprofile::roles.types.author",[],"en")],
        'es' => ['title' => trans("iprofile::roles.types.author",[],"es")],
        'permissions' => [
                    'profile.api.login' => true,
                    'profile.user.index' => true,
                    'iblog.posts.manage' => true,
                    'iblog.posts.index' => true,
                    'iblog.posts.create' => true,
                    'iblog.posts.edit' => true,
        ]
      ]
        ];

        //Create Roles
        foreach ($roles as $role) {

      $resultRole = createOrUpdateRole($role);
      
            }

    //To update de IprofileSetting 'assignedRoles'
    ProcessSeeds::dispatch([
      "baseClass" => "\Modules\Iprofile\Database\Seeders",
      "seeds" => ["RolePermissionsSeeder"]
    ]);
    

    }
}
