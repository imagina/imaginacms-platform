<?php

namespace Modules\Ischedulable\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\Ischedulable\Entities\Day;

class DaysDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Model::unguard();
        //Insert week day monday
        if (! Day::where('iso', 1)->first()) {
            Day::create(['iso' => 1, 'es' => ['name' => 'lunes'], 'en' => ['name' => 'monday']]);
        }
        //Insert week day tuesday
        if (! Day::where('iso', 2)->first()) {
            Day::create(['iso' => 2, 'es' => ['name' => 'martes'], 'en' => ['name' => 'tuesday']]);
        }
        //Insert week day Wednesday
        if (! Day::where('iso', 3)->first()) {
            Day::create(['iso' => 3, 'es' => ['name' => 'miercoles'], 'en' => ['name' => 'wednesday']]);
        }
        //Insert week day thursday
        if (! Day::where('iso', 4)->first()) {
            Day::create(['iso' => 4, 'es' => ['name' => 'jueves'], 'en' => ['name' => 'thursday']]);
        }
        //Insert week Friday
        if (! Day::where('iso', 5)->first()) {
            Day::create(['iso' => 5, 'es' => ['name' => 'viernes'], 'en' => ['name' => 'friday']]);
        }
        //Insert week saturday
        if (! Day::where('iso', 6)->first()) {
            Day::create(['iso' => 6, 'es' => ['name' => 'sabado'], 'en' => ['name' => 'saturday']]);
        }
        //Insert week sunday
        if (! Day::where('iso', 7)->first()) {
            Day::create(['iso' => 7, 'es' => ['name' => 'domingo'], 'en' => ['name' => 'sunday']]);
        }
    }
}
