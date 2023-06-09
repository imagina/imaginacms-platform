<?php

namespace Modules\Icommercepricelist\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class IcommercepricelistModuleTableSeeder extends Seeder
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
            ['config' => 'config', 'name' => 'config'],
            ['config' => 'crud-fields', 'name' => 'crud_fields'],
            ['config' => 'permissions', 'name' => 'permissions'],
        ];

        $moduleRegisterService = app("Modules\Isite\Services\RegisterModuleService");

        $moduleRegisterService->registerModule('icommercepricelist', $columns, 1);
    }
}
