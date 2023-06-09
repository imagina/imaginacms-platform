<?php

namespace Modules\Icommercepayu\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Isite\Jobs\ProcessSeeds;

class IcommercepayuDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        ProcessSeeds::dispatch([
            'baseClass' => "\Modules\Icommercepayu\Database\Seeders",
            'seeds' => ['IcommercepayuModuleTableSeeder', 'IcommercepayuSeeder'],
        ]);
    }
}
