<?php

namespace Modules\Icommercepayu\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\Icommerce\Entities\PaymentMethod;

class IcommercepayuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Model::unguard();

        if (! is_module_enabled('Icommercepayu')) {
            $this->command->alert('This module: Icommercepayu is DISABLED!! , please enable the module and then run the seed');
            exit();
        }

        //Validation if the module has been installed before
        $name = config('asgard.icommercepayu.config.paymentName');
        $result = PaymentMethod::where('name', $name)->first();

        if (! $result) {
            $options['init'] = "Modules\Icommercepayu\Http\Controllers\Api\IcommercePayuApiController";
            $options['mainimage'] = null;
            $options['merchantId'] = '508029';
            $options['apiLogin'] = 'pRRXKOl8ikMmt9u';
            $options['apiKey'] = '4Vj8eK4rloUd272L48hsrarnUA';
            $options['accountId'] = '512321';
            $options['mode'] = 'sandbox';
            $options['test'] = 1;
            $options['minimunAmount'] = 15000;
            $options['showInCurrencies'] = ['COP'];

            $titleTrans = 'icommercepayu::icommercepayus.single';
            $descriptionTrans = 'icommercepayu::icommercepayus.description';

            $params = [
                'name' => $name,
                'status' => 1,
                'options' => $options,
                'organization_id' => isset(tenant()->id) ? tenant()->id : null,
            ];
            $paymentMethod = PaymentMethod::create($params);

            $this->addTranslation($paymentMethod, 'en', $titleTrans, $descriptionTrans);
            $this->addTranslation($paymentMethod, 'es', $titleTrans, $descriptionTrans);
        } else {
            //It doesn't work in jobs
            //$this->command->alert("This method has already been installed !!");
        }
    }

    /*
    * Add Translations
    * PD: New Alternative method due to problems with astronomic translatable
    **/
    public function addTranslation($paymentMethod, $locale, $title, $description)
    {
        \DB::table('icommerce__payment_method_translations')->insert([
            'title' => trans($title, [], $locale),
            'description' => trans($description, [], $locale),
            'payment_method_id' => $paymentMethod->id,
            'locale' => $locale,
        ]);
    }
}
