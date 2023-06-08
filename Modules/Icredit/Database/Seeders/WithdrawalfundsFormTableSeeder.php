<?php

namespace Modules\Icredit\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class WithdrawalfundsFormTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
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
      $form = $formRepository->getItem("icredit_withdrawal_funds_form", json_decode(json_encode($params)));
      if (!isset($form->id)) {
    
        $form = $formRepository->create([
          "title" => trans("icredit::credits.withdrawalFundsForm.form.title.single"),
          "system_name" => "icredit_withdrawal_funds_form",
          "active" => true
        ]);
    
        $block = $blockRepository->create([
          "form_id" => $form->id
        ]);
    
        $fieldRepository->create([
          "form_id" => $form->id,
          "block_id" => $block->id,
          "es" => [
            "label" => trans("icredit::credits.withdrawalFundsForm.form.fields.amount", [], "es"),
          ],
          "en" => [
            "label" => trans("icredit::credits.withdrawalFundsForm.form.fields.amount", [], "en"),
          ],
          "type" => 3,
          "name" => "amount",
          "required" => true,
        ]);
    
    
        $settingRepository->createOrUpdate(["icredit::icreditWithdrawalFundsForm" => $form->id]);
      }
    }
}
