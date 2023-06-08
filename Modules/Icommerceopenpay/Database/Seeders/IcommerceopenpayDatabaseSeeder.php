<?php

namespace Modules\Icommerceopenpay\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Icommerce\Entities\PaymentMethod;

class IcommerceopenpayDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        Model::unguard();

        $this->call(IcommerceopenpayModuleTableSeeder::class);
        
        if(!is_module_enabled('Icommerceopenpay')){
            $this->command->alert("This module: Icommerceopenpay is DISABLED!! , please enable the module and then run the seed");
            exit();
        }
        
        //Validation if the module has been installed before
        $name = config('asgard.icommerceopenpay.config.paymentName');
        $result = PaymentMethod::where('name',$name)->first();

        if(!$result){

            $options['init'] = "Modules\Icommerceopenpay\Http\Controllers\Api\IcommerceOpenpayApiController";
            
            $options['merchantId'] = null;
            $options['publicKey'] = null;
            $options['privateKey'] = null;
            $options['mode'] = "sandbox";
            $options['minimunAmount'] = 0;
            $options['maximumAmount'] = null;
            $options['webhookVerificationCode'] = null;
            $options['showInCurrencies'] = ["COP"];
      
            $titleTrans = 'icommerceopenpay::icommerceopenpays.single';
            $descriptionTrans = 'icommerceopenpay::icommerceopenpays.description';

            $params = array(
              'name' => $name,
              'status' => 1,
              'options' => $options
            );
            $paymentMethod = PaymentMethod::create($params);

            $this->addTranslation($paymentMethod,'en',$titleTrans,$descriptionTrans);
            $this->addTranslation($paymentMethod,'es',$titleTrans,$descriptionTrans);

        }else{

            $this->command->alert("This method has already been installed !!");

        }
   
    }


    /*
    * Add Translations
    * PD: New Alternative method due to problems with astronomic translatable
    **/
    public function addTranslation($paymentMethod,$locale,$title,$description){

      \DB::table('icommerce__payment_method_translations')->insert([
          'title' => trans($title,[],$locale),
          'description' => trans($description,[],$locale),
          'payment_method_id' => $paymentMethod->id,
          'locale' => $locale
      ]);
 
    }


}
