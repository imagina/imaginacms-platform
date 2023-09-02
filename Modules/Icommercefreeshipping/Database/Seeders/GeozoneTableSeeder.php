<?php

namespace Modules\Icommercefreeshipping\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\Ilocations\Entities\Geozones;

class GeozoneTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Model::unguard();

        $params = [
            'name' => 'freeshipping',
            'description' => 'geozone with freeshipping',
        ];

        $newGeozone = Geozones::create($params);

        $newData['icommercefreeshipping::geozone'] = $newGeozone->id;

        $setting = app('Modules\Setting\Repositories\SettingRepository');
        $setting->createOrUpdate($newData);
    }
}
