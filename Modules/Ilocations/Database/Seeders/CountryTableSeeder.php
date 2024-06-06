<?php

namespace Modules\Ilocations\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Ilocations\Entities\Country;


class CountryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
  
     
        $path = base_path('/Modules/Ilocations/Assets/js/countries.json');
        $countries = json_decode(file_get_contents($path), true);

        foreach ($countries as $key => $country)
            Country::create($country);
    }
}
