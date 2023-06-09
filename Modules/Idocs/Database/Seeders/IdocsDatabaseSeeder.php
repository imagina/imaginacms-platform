<?php

namespace Modules\Idocs\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\Isite\Jobs\ProcessSeeds;

class IdocsDatabaseSeeder extends Seeder
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
            'baseClass' => "\Modules\Idocs\Database\Seeders",
            'seeds' => ['IdocsModuleTableSeeder'],
        ]);
    }
}
