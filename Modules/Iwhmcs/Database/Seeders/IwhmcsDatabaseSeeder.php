<?php

namespace Modules\Iwhmcs\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class IwhmcsDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Model::unguard();

        $this->call(IwhmcsModuleTableSeeder::class);
        // $this->call("OthersTableSeeder");
    }
}
