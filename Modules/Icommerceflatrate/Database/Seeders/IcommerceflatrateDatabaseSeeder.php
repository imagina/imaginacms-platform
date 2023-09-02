<?php

namespace Modules\Icommerceflatrate\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\Icommerce\Entities\ShippingMethod;

class IcommerceflatrateDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Model::unguard();

        $this->call(IcommerceflatrateModuleTableSeeder::class);

        $methods = config('asgard.icommerceflatrate.config.methods');

        if (count($methods) > 0) {
            $init = "Modules\Icommerceflatrate\Http\Controllers\Api\IcommerceFlatrateApiController";

            foreach ($methods as $key => $method) {
                $result = ShippingMethod::where('name', $method['name'])->first();

                if (! $result) {
                    $options['init'] = $init;

                    $options['cost'] = 0;

                    $titleTrans = $method['title'];
                    $descriptionTrans = $method['description'];

                    foreach (['en', 'es'] as $locale) {
                        if ($locale == 'en') {
                            $params = [
                                'title' => trans($titleTrans),
                                'description' => trans($descriptionTrans),
                                'name' => $method['name'],
                                'status' => $method['status'],
                                'options' => $options,
                            ];

                            if (isset($method['parent_name'])) {
                                $params['parent_name'] = $method['parent_name'];
                            }

                            $shippingMethod = ShippingMethod::create($params);
                        } else {
                            $title = trans($titleTrans, [], $locale);
                            $description = trans($descriptionTrans, [], $locale);

                            $shippingMethod->translateOrNew($locale)->title = $title;
                            $shippingMethod->translateOrNew($locale)->description = $description;

                            $shippingMethod->save();
                        }
                    }// Foreach
                } else {
                    $this->command->alert("This method: {$method['name']} has already been installed !!");
                }
            }
        } else {
            $this->command->alert('No methods in the Config File !!');
        }
    }
}
