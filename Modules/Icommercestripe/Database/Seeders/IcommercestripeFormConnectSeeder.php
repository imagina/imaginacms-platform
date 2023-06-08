<?php

namespace Modules\Icommercestripe\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Icommerce\Entities\PaymentMethod;

//Events
use Modules\Iforms\Events\SyncFormeable;

class IcommercestripeFormConnectSeeder extends Seeder
{


   
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run($paymentMethod=null)
    {
        
        Model::unguard();
        
        $formRepository = app("Modules\Iforms\Repositories\FormRepository");
        $blockRepository = app("Modules\Iforms\Repositories\BlockRepository");
        $fieldRepository = app("Modules\Iforms\Repositories\FieldRepository");
        $settingRepository = app("Modules\Setting\Repositories\SettingRepository");
        $locale = \LaravelLocalization::setLocale() ?: \App::getLocale();
        $params = [
            "filter" => [
              "field" => "system_name",
            ],
            "include" => [],
            "fields" => [],
          ];

        $formName = "iform_icommercestripe_connect";

        $form = $formRepository->getItem($formName, json_decode(json_encode($params)));
        if (!isset($form->id)) {

            $form = $formRepository->create([
                "title" => trans("icommercestripe::forms.connect.title"),
                "system_name" => $formName,
                "active" => true
            ]);



            $fieldsBlock = $blockRepository->create([
                "form_id" => $form->id,
                "name" => "fields"
            ]);

            // Email
            $fieldRepository->create([
              "form_id" => $form->id,
              "block_id" => $fieldsBlock->id,
              "es" => [
                "label" => trans("icommercestripe::forms.connect.fields.email", [], "es"),
              ],
              "en" => [
                "label" => trans("icommercestripe::forms.connect.fields.email", [], "en"),
              ],
              "type" => 1,
              "name" => "email",
              "required" => true,
            ]);

            // Country
            $fieldRepository->create([
              "form_id" => $form->id,
              "block_id" => $fieldsBlock->id,
              "es" => [
                "label" => trans("icommercestripe::forms.connect.fields.country", [], "es"),
              ],
              "en" => [
                "label" => trans("icommercestripe::forms.connect.fields.country", [], "en"),
              ],
              "type" => 5,
              "name" => "country",
              'options' => [
                'props' => [
                  'useChips' => true
                ],
                'loadOptions' => [
                  'apiRoute' => 'v2/ilocations/countries',
                  'select' => ['label' => 'name', 'id' => 'iso2'],
                  'requestParams' => [
                    "filter" => [
                      "indexAll" => true,
                      "iso2" => $paymentMethod->options->connectCountries
                    ]
                  ]
                ],
              ],
              "required" => true,
            ]);

        }

        event( new SyncFormeable($paymentMethod,["form_id" => $form->id]));
   
    }


   


}
