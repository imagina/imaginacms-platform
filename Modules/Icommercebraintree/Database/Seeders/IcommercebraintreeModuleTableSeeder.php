<?php

namespace Modules\Icommercebraintree\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class IcommercebraintreeModuleTableSeeder extends Seeder
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

        $moduleRegisterService->registerModule('icommercebraintree', $columns, 1);
    }
}
