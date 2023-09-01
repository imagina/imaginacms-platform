<?php

namespace Modules\Qreable\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class QreableDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Model::unguard();

        $this->call(QreableModuleTableSeeder::class);
        // $this->call("OthersTableSeeder");
    }
}
