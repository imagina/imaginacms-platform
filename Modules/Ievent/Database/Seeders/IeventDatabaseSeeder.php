<?php

namespace Modules\Ievent\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class IeventDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(IeventModuleTableSeeder::class);
        // $this->call("OthersTableSeeder");
    }
}
