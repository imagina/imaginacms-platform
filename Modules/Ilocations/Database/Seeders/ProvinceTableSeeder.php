<?php

namespace Modules\Ilocations\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Ilocations\Entities\Province;
use Modules\Ilocations\Entities\Country;

class ProvinceTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    Model::unguard();
    
    
    $path = base_path('/Modules/Ilocations/Assets/js/provinces.json');
    $provinces = collect(json_decode(file_get_contents($path), false));
    $countries = Country::all();
    $currentProvinces = Province::all();
    $provincesToCreate = [];
    
      foreach ($provinces as $province) {
          $currentProvince =  Province::where("iso_2", $province->iso_2)->first();
          if (!isset($currentProvince->id)) {
            $country = $countries->where("iso_2", $province->country)->first();
            Province::create([
              'name' => $province->region,
              'iso_2' => $province->iso_2,
              'country_id' => $country->id
            ]);
            
          }
        
      }
   
  }
}
