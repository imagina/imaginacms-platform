<?php

namespace Modules\Icommercepaymentez\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\Icommerce\Entities\PaymentMethod;

class IcommercepaymentezDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Model::unguard();

        $this->call(IcommercepaymentezModuleTableSeeder::class);

        if (! is_module_enabled('Icommercepaymentez')) {
            $this->command->alert('This module: Icommercepaymentez is DISABLED!! , please enable the module and then run the seed');
            exit();
        }

        //Validation if the module has been installed before
        $name = config('asgard.icommercepaymentez.config.paymentName');
        $result = PaymentMethod::where('name', $name)->first();

        if (! $result) {
            $options['init'] = "Modules\Icommercepaymentez\Http\Controllers\Api\IcommercePaymentezApiController";

            $options['mode'] = 'sandbox';
            $options['serverAppCode'] = null;
            $options['serverAppKey'] = null;
            $options['clientAppCode'] = null;
            $options['clientAppKey'] = null;
            $options['type'] = 'checkout';
            $options['allowedPaymentMethods'] = [];
            $options['minimunAmount'] = 0;
            $options['maximumAmount'] = null;
            $options['showInCurrencies'] = ['COP'];

            $titleTrans = 'icommercepaymentez::icommercepaymentezs.single';
            $descriptionTrans = 'icommercepaymentez::icommercepaymentezs.description';

            $params = [
                'name' => $name,
                'status' => 1,
                'options' => $options,
            ];
            $paymentMethod = PaymentMethod::create($params);

            $this->addTranslation($paymentMethod, 'en', $titleTrans, $descriptionTrans);
            $this->addTranslation($paymentMethod, 'es', $titleTrans, $descriptionTrans);
        } else {
            $this->command->alert('This method has already been installed !!');
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
