<?php

namespace Modules\Ilocations\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Ilocations\Entities\City;

class CityTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    Model::unguard();
  
    DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    DB::table('ilocations__cities')->truncate();
    DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    
    $path = base_path('/Modules/Ilocations/Assets/js/citiesCO.json');
    $cities = json_decode(file_get_contents($path), true);

    foreach ($cities as $key => $city)
      City::create($city);
  }
}
