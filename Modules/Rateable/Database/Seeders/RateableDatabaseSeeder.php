<?php

namespace Modules\Rateable\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class RateableDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(RateableModuleTableSeeder::class);
        // $this->call("OthersTableSeeder");
    }
}
