<?php

namespace Modules\Ibuilder\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\Isite\Jobs\ProcessSeeds;

class IbuilderDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Model::unguard();
        ProcessSeeds::dispatch([
            'baseClass' => "\Modules\Ibuilder\Database\Seeders",
            'seeds' => ['IbuilderModuleTableSeeder', 'FixBlocksMovedSeeder'],
        ]);
    }
}
