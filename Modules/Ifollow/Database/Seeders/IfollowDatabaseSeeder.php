<?php

namespace Modules\Ifollow\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class IfollowDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Model::unguard();

        $this->call(IfollowModuleTableSeeder::class);
        // $this->call("OthersTableSeeder");
    }
}
