<?php

namespace Modules\Icommercecredibanco\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\Icommerce\Entities\PaymentMethod;

class IcommercecredibancoDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Model::unguard();

        $this->call(IcommercecredibancoModuleTableSeeder::class);

        $name = config('asgard.icommercecredibanco.config.paymentName');
        $result = PaymentMethod::where('name', $name)->first();

        if (! $result) {
            $options['init'] = "Modules\Icommercecredibanco\Http\Controllers\Api\IcommerceCredibancoApiController";

            $options['mainimage'] = null;
            $options['user'] = '';
            $options['password'] = '';
            $options['merchantId'] = '';
            $options['mode'] = 'sandbox';
            $options['minimunAmount'] = 0;
            $options['showInCurrencies'] = ['COP'];

            $titleTrans = 'icommercecredibanco::icommercecredibancos.single';
            $descriptionTrans = 'icommercecredibanco::icommercecredibancos.description';

            foreach (['en', 'es'] as $locale) {
                if ($locale == 'en') {
                    $params = [
                        'title' => trans($titleTrans),
                        'description' => trans($descriptionTrans),
                        'name' => $name,
                        'status' => 1,
                        'options' => $options,
                    ];

                    $paymentMethod = PaymentMethod::create($params);
                } else {
                    $title = trans($titleTrans, [], $locale);
                    $description = trans($descriptionTrans, [], $locale);

                    $paymentMethod->translateOrNew($locale)->title = $title;
                    $paymentMethod->translateOrNew($locale)->description = $description;

                    $paymentMethod->save();
                }
            }// Foreach
        } else {
            $this->command->alert('This method has already been installed !!');
        }
    }
}
