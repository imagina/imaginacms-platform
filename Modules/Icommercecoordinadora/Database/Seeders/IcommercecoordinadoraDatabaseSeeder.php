<?php

namespace Modules\Icommercecoordinadora\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Icommerce\Entities\ShippingMethod;

class IcommercecoordinadoraDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $this->call(IcommercecoordinadoraModuleTableSeeder::class);

        $name = config('asgard.icommercecoordinadora.config.shippingName');
        $result = ShippingMethod::where('name',$name)->first();

        if(!$result){

            $options['init'] = "Modules\Icommercecoordinadora\Http\Controllers\Api\IcommerceCoordinadoraApiController";
            $options['apiKey'] = null;
            $options['password'] = null;
            $options['cityOrigin'] = null;
            $options['mode'] = "sandbox";
           
      
            $titleTrans = 'icommercecoordinadora::icommercecoordinadoras.single';
            $descriptionTrans = 'icommercecoordinadora::icommercecoordinadoras.description';

            $params = array(
              'name' => $name,
              'status' => 1,
              'options' => $options
            );
            $shippingMethod = ShippingMethod::create($params);

            $this->addTranslation($shippingMethod,'en',$titleTrans,$descriptionTrans);
            $this->addTranslation($shippingMethod,'es',$titleTrans,$descriptionTrans);

          }else{

            $this->command->alert("This method has already been installed !!");

          }

    }

    /*
    * Add Translations
    * PD: New Alternative method due to problems with astronomic translatable
    **/
    public function addTranslation($shippingMethod,$locale,$title,$description){

      \DB::table('icommerce__shipping_method_translations')->insert([
          'title' => trans($title,[],$locale),
          'description' => trans($description,[],$locale),
          'shipping_method_id' => $shippingMethod->id,
          'locale' => $locale
      ]);

    }

}
