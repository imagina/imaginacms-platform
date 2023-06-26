<?php

namespace Modules\Icommercewompi\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class IcommercewompiModuleTableSeeder extends Seeder
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
            ['config' => 'crud-fields', 'name' => 'crud_fields'],
            ['config' => 'permissions', 'name' => 'permissions'],
        ];

        $moduleRegisterService = app("Modules\Isite\Services\RegisterModuleService");

        $moduleRegisterService->registerModule('icommercewompi', $columns, 1);
    }
}
