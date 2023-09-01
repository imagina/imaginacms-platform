<?php

namespace Modules\Iappointment\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\Isite\Jobs\ProcessSeeds;

class IappointmentDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Model::unguard();
        ProcessSeeds::dispatch([
            'baseClass' => "\Modules\Iappointment\Database\Seeders",
            'seeds' => ['IappointmentModuleTableSeeder', 'AppointmentStatusTableSeeder'],
        ]);
    }
}
