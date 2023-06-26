<?php

namespace Modules\Isite\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class IsiteModuleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Model::unguard();

        $columns = [
            ['config' => 'config', 'name' => 'config'],
            ['config' => 'settings-fields', 'name' => 'settings'],
            ['config' => 'permissions', 'name' => 'permissions'],
            ['config' => 'deprecated-settings', 'name' => 'deprecated_settings'],
            ['config' => 'cmsPages', 'name' => 'cms_pages'],
            ['config' => 'cmsSidebar', 'name' => 'cms_sidebar'],
            ['config' => 'crud-fields', 'name' => 'crud_fields'],
        ];

        $moduleRegisterService = app("Modules\Isite\Services\RegisterModuleService");

        $moduleRegisterService->registerModule('isite', $columns, 10000);
    }
}
