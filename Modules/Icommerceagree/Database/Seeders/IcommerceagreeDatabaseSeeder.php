<?php

namespace Modules\Icommerceagree\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Isite\Jobs\ProcessSeeds;

class IcommerceagreeDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProcessSeeds::dispatch([
            'baseClass' => "\Modules\Icommerceagree\Database\Seeders",
            'seeds' => ['IcommerceagreeModuleTableSeeder', 'IcommerceagreeSeeder'],
        ]);
    }
}