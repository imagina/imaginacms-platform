<?php

namespace Modules\Icommerceepayco\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\Icommerce\Entities\PaymentMethod;

class IcommerceepaycoDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Model::unguard();

        $this->call(IcommerceepaycoModuleTableSeeder::class);
        $name = config('asgard.icommerceepayco.config.paymentName');
        $result = PaymentMethod::where('name', $name)->first();

        if (! $result) {
            $options['init'] = "Modules\Icommerceepayco\Http\Controllers\Api\IcommerceEpaycoApiController";
            $options['mainimage'] = null;
            $options['publicKey'] = null;
            $options['clientId'] = null;
            $options['pKey'] = null;
            $options['autoClick'] = true;
            $options['test'] = true;
            $options['minimunAmount'] = 15000;
            $options['showInCurrencies'] = ['COP'];

            $titleTrans = 'Epayco';
            $descriptionTrans = 'icommerceepayco::icommerceepaycos.description';

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
