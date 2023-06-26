<?php

namespace Modules\Icommercecheckmo\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Isite\Jobs\ProcessSeeds;

class IcommercecheckmoDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProcessSeeds::dispatch([
            'baseClass' => "\Modules\Icommercecheckmo\Database\Seeders",
            'seeds' => ['IcommercecheckmoModuleTableSeeder', 'IcommercecheckmoSeeder'],
        ]);
    }
}
