<?php

namespace Modules\Iblog\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\Isite\Jobs\ProcessSeeds;

class IblogDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Model::unguard();
        ProcessSeeds::dispatch([
            'baseClass' => "\Modules\Iblog\Database\Seeders",
            'seeds' => ['IblogModuleTableSeeder', 'RoleTableSeeder', 'SlugCheckerTableSeeder', 'LayoutsBlogTableSeeder',
                'MoveStatusToPostsTranslationsTableSeeder', 'MoveStatusToCategoryTranslationsTable'],
        ]);
    }
}
