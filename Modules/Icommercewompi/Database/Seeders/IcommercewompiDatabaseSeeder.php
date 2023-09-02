<?php

namespace Modules\Icommercewompi\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\Icommerce\Entities\PaymentMethod;

class IcommercewompiDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Model::unguard();

        $this->call(IcommercewompiModuleTableSeeder::class);

        $name = config('asgard.icommercewompi.config.paymentName');
        $result = PaymentMethod::where('name', $name)->first();

        if (! $result) {
            $options['init'] = "Modules\Icommercewompi\Http\Controllers\Api\IcommerceWompiApiController";
            $options['mainimage'] = null;
            $options['publicKey'] = null;
            $options['privateKey'] = null;
            $options['eventSecretKey'] = null;
            $options['mode'] = 'sandbox';
            $options['minimunAmount'] = 15000;
            $options['showInCurrencies'] = ['COP'];

            $titleTrans = 'Wompi';
            $descriptionTrans = 'icommercewompi::icommercewompis.description';

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
            'title' => $title,
            'description' => trans($description, [], $locale),
            'payment_method_id' => $paymentMethod->id,
            'locale' => $locale,
        ]);
    }
}
