<?php

namespace Modules\Imeeting\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use Modules\Imeeting\Entities\Provider;

class ZoomProviderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $name = config('asgard.imeeting.config.providers.zoom.name');
        $result = Provider::where('name',$name)->first();

        if(!$result){

            $options['apiKey'] = null;
            $options['apiSecret'] = null;
      
            $titleTrans = 'Zoom';
            $descriptionTrans = 'imeeting::providers.zoom.description';

            $params = array(
              'name' => $name,
              'status' => 1,
              'options' => $options
            );
            $provider = Provider::create($params);

            $this->addTranslation($provider,'en',$titleTrans,$descriptionTrans);
            $this->addTranslation($provider,'es',$titleTrans,$descriptionTrans);

          }else{

            $this->command->alert("This provider has already been installed !!");

          }

 
    }

     /*
    * Add Translations
    * PD: New Alternative method due to problems with astronomic translatable
    **/
    public function addTranslation($provider,$locale,$title,$description){

      \DB::table('imeeting__provider_translations')->insert([
          'title' => trans($title,[],$locale),
          'description' => trans($description,[],$locale),
          'provider_id' => $provider->id,
          'locale' => $locale
      ]);

    }

}
