<?php

namespace Modules\Iforms\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class IformsModuleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $columns = [
            ['config' => 'cmsPages', 'name' => 'cms_pages'],
            ['config' => 'cmsSidebar', 'name' => 'cms_sidebar'],
            ['config' => 'config', 'name' => 'config'],
            ['config' => 'crud-fields', 'name' => 'crud_fields'],
            ['config' => 'permissions', 'name' => 'permissions'],
            ['config' => 'settings-fields', 'name' => 'settings'],
        ];

        $moduleRegisterService = app("Modules\Isite\Services\RegisterModuleService");

        $moduleRegisterService->registerModule('iforms', $columns);
    }
}