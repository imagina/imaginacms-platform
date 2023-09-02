<?php

namespace Modules\User\Database\Seeders;

use Illuminate\Database\Seeder;

class UserDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $this->call(UserModuleTableSeeder::class);
        $this->call(SentinelGroupSeedTableSeeder::class);
    }
}
