<?php

namespace Modules\Imeeting\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class ImeetingDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Model::unguard();

        $this->call(ImeetingModuleTableSeeder::class);
        $this->call(ZoomProviderSeeder::class);
    }
}
