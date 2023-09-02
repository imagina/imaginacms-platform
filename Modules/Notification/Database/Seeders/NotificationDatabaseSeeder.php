<?php

namespace Modules\Notification\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\Isite\Jobs\ProcessSeeds;

class NotificationDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Model::unguard();
        ProcessSeeds::dispatch([
            'baseClass' => "\Modules\Notification\Database\Seeders",
            'seeds' => ['NotificationTypeTableSeeder', 'NotificationTypeTableSeeder', 'NotificationProviderTableSeeder'],
        ]);
    }
}
