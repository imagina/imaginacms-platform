<?php

namespace Modules\Icommercepaypal\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class IcommercepaypalModuleTableSeeder extends Seeder
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

        $moduleRegisterService->registerModule('icommercepaypal', $columns, 1);
    }
}
