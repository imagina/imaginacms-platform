<?php

namespace Modules\Ifollow\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class IfollowDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(IfollowModuleTableSeeder::class);
        // $this->call("OthersTableSeeder");
    }
}
