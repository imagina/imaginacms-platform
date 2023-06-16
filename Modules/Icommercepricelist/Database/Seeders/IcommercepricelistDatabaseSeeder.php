<?php

namespace Modules\Icommercepricelist\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\Isite\Jobs\ProcessSeeds;

class IcommercepricelistDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        ProcessSeeds::dispatch([
            'baseClass' => "\Modules\Icommercepricelist\Database\Seeders",
            'seeds' => ['IcommercepricelistModuleTableSeeder'],
        ]);
    }
}
