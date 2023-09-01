<?php

namespace Modules\Icommerceauthorize\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\Icommerce\Entities\PaymentMethod;

class IcommerceauthorizeDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Model::unguard();

        $this->call(IcommerceauthorizeModuleTableSeeder::class);
        if (! is_module_enabled('Icommerceauthorize')) {
            $this->command->alert('This module: Icommerceauthorize is DISABLED!! , please enable the module and then run the seed');
            exit();
        }

        //Validation if the module has been installed before
        $name = config('asgard.icommerceauthorize.config.paymentName');
        $result = PaymentMethod::where('name', $name)->first();

        if (! $result) {
            $options['init'] = "Modules\Icommerceauthorize\Http\Controllers\Api\IcommerceAuthorizeApiController";
            $options['apiLogin'] = '';
            $options['transactionKey'] = '';
            $options['clientKey'] = '';
            $options['mode'] = 'sandbox';
            $options['minimunAmount'] = 0;
            $options['maximumAmount'] = null;
            $options['showInCurrencies'] = ['USD'];

            $titleTrans = 'Authorize';
            $descriptionTrans = 'icommerceauthorize::icommerceauthorizes.description';

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
