<?php

namespace Modules\Media\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\Isite\Jobs\ProcessSeeds;

class MediaDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Model::unguard();
        Model::unguard();
        ProcessSeeds::dispatch([
            'baseClass' => "\Modules\Media\Database\Seeders",
            'seeds' => ['MediaModuleTableSeeder', 'DeleteSvgOfImageTypes'],
        ]);
    }
}
