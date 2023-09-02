<?php

namespace Modules\Icommercebraintree\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\Icommerce\Entities\PaymentMethod;

class IcommercebraintreeDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Model::unguard();

        $this->call(IcommercebraintreeModuleTableSeeder::class);
        $name = config('asgard.icommercebraintree.config.paymentName');
        $result = PaymentMethod::where('name', $name)->first();

        if (! $result) {
            $options['init'] = "Modules\Icommercebraintree\Http\Controllers\Api\IcommerceBraintreeApiController";

            $options['merchantId'] = null;
            $options['publicKey'] = null;
            $options['privateKey'] = null;
            $options['mode'] = 'sandbox';
            $options['minimunAmount'] = 0;

            $titleTrans = 'icommercebraintree::icommercebraintrees.single';
            $descriptionTrans = 'icommercebraintree::icommercebraintrees.description';

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
