<?php

namespace Modules\Iappointment\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\Isite\Jobs\ProcessSeeds;

class IappointmentDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        ProcessSeeds::dispatch([
            'baseClass' => "\Modules\Iappointment\Database\Seeders",
            'seeds' => ['IappointmentModuleTableSeeder', 'AppointmentStatusTableSeeder'],
        ]);
    }
}
