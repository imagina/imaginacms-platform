<?php

namespace Modules\Icommercecheckmo\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class IcommercecheckmoModuleTableSeeder extends Seeder
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

        $moduleRegisterService->registerModule('icommercecheckmo', $columns, 1);
    }
}
