<?php

namespace Modules\Icommercepricelist\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\Isite\Jobs\ProcessSeeds;

class IcommercepricelistDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Model::unguard();
        ProcessSeeds::dispatch([
            'baseClass' => "\Modules\Icommercepricelist\Database\Seeders",
            'seeds' => ['IcommercepricelistModuleTableSeeder'],
        ]);
    }
}
