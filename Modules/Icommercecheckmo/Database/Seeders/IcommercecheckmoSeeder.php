<?php

namespace Modules\Icommercecheckmo\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Icommerce\Entities\PaymentMethod;

class IcommercecheckmoSeeder extends Seeder
{
 

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run($methodsFromOther=null)
    {

        Model::unguard();

        $methods = config('asgard.icommercecheckmo.config.methods');

        //Only the methods that match with the config
        if(!is_null($methodsFromOther))
            $methods = array_intersect_key($methods,$methodsFromOther);

        if(count($methods)>0){

            $init = "Modules\Icommercecheckmo\Http\Controllers\Api\IcommerceCheckmoApiController";

            foreach ($methods as $key => $method) {

                $result = PaymentMethod::where('name',$method['name'])->first();

                if(!$result){

                    $options['init'] = $init;

                    $options['mainimage'] = null;
                    $options['minimunAmount'] = 0;

                    $titleTrans = $method['title'];
                    $descriptionTrans = $method['description'];

                    $params = array(
                        'name' => $method['name'],
                        'status' => $method['status'],
                        'options' => $options,
                        'organization_id' => isset(tenant()->id) ? tenant()->id : null
                    );

                    if(isset($method['parent_name']))
                        $params['parent_name'] = $method['parent_name'];

                    $paymentMethod = PaymentMethod::create($params);

                    $this->addTranslation($paymentMethod,'en',$titleTrans,$descriptionTrans);
                    $this->addTranslation($paymentMethod,'es',$titleTrans,$descriptionTrans);
                    

                }else{
                    //It doesn't work in jobs
                    // $this->command->alert("This method: {$method['name']} has already been installed !!");
                }
            }
        }else{
            //It doesn't work in jobs
           //$this->command->alert("No methods in the Config File !!"); 
        }
       
        
    }

    /*
    * Add Translations
    * PD: New Alternative method due to problems with astronomic translatable
    **/
    public function addTranslation($paymentMethod,$locale,$title,$description)
    {

        \DB::table('icommerce__payment_method_translations')->insert([
            'title' => trans($title,[],$locale),
            'description' => trans($description,[],$locale),
            'payment_method_id' => $paymentMethod->id,
            'locale' => $locale
        ]);
  
    }

    
    
}
