<?php

namespace Modules\Ilocations\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\Ilocations\Entities\Geozones;
use Modules\Ilocations\Entities\GeozonesCountries;

class GeozoneTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Model::unguard();
        $path = base_path('/Modules/Ilocations/Assets/js/geozone.json');
        $geozones = json_decode(file_get_contents($path), true);

        foreach ($geozones as $key => &$geozone) {
            $zones = $geozone['zones'];
            unset($geozone['zones']);
            $geozoneCreated = Geozones::updateOrCreate($geozone);
            foreach ($zones as &$zone) {
                GeozonesCountries::updateOrCreate($zone);
            }
        }
    }
}
