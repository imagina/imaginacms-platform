<?php


namespace Modules\Iforms\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Iforms\Entities\Block;
use Modules\Iforms\Entities\Form;

class ContactFormTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $seedUniquesUse = DB::table('isite__seeds')->where("name", 'ContactFormTableSeeder')->first();
    if (empty($seedUniquesUse)) {
      \DB::beginTransaction();
      try {

        $formRepository = app("Modules\Iforms\Repositories\FormRepository");
        $blockRepository = app("Modules\Iforms\Repositories\BlockRepository");
        $fieldRepository = app("Modules\Iforms\Repositories\FieldRepository");

        $params = [
          "filter" => [
            "field" => "system_name",
          ],
          "include" => [],
          "fields" => [],
        ];
        $form = $formRepository->getItem("contact_form", json_decode(json_encode($params)));
        if (!isset($form->id)) {

          $form = $formRepository->create([
            "es" => [
              "title" => trans("iforms::common.seeds.titleForm", [], "es"),
            ],
            "en" => [
              "title" => trans("iforms::common.seeds.titleForm", [], "en"),
            ],
            "system_name" => "contact_form",
            "active" => true
          ]);

          $block = $blockRepository->create([
            "form_id" => $form->id
          ]);

          $fieldRepository->create([
            "form_id" => $form->id,
            "block_id" => $block->id,
            "es" => [
              "label" => trans("iforms::common.seeds.fullName", [], "es"),
              "placeholder" => trans("iforms::common.seeds.fullName", [], "es"),
            ],
            "en" => [
              "label" => trans("iforms::common.seeds.fullName", [], "en"),
              "placeholder" => trans("iforms::common.seeds.fullName", [], "en"),
            ],
            "type" => 1,
            "name" => "full_name",
            "required" => true,
          ]);

          $fieldRepository->create([
            "form_id" => $form->id,
            "block_id" => $block->id,
            "es" => [
              "label" => trans("iforms::common.seeds.email", [], "es"),
              "placeholder" => trans("iforms::common.seeds.email", [], "es"),
            ],
            "en" => [
              "label" => trans("iforms::common.seeds.email", [], "en"),
              "placeholder" => trans("iforms::common.seeds.email", [], "en"),
            ],
            "type" => 4,
            "name" => "email",
            "required" => true,
          ]);

          $fieldRepository->create([
            "form_id" => $form->id,
            "block_id" => $block->id,
            "es" => [
              "label" => trans("iforms::common.seeds.phone", [], "es"),
              "placeholder" => trans("iforms::common.seeds.phone", [], "es"),
            ],
            "en" => [
              "label" => trans("iforms::common.seeds.phone", [], "en"),
              "placeholder" => trans("iforms::common.seeds.phone", [], "en"),
            ],
            "type" => 10,
            "name" => "telephone",
            "required" => true,
          ]);

          $fieldRepository->create([
            "form_id" => $form->id,
            "block_id" => $block->id,
            "es" => [
              "label" => trans("iforms::common.seeds.message", [], "es"),
              "placeholder" => trans("iforms::common.seeds.message", [], "es"),
            ],
            "en" => [
              "label" => trans("iforms::common.seeds.message", [], "en"),
              "placeholder" => trans("iforms::common.seeds.message", [], "en"),
            ],
            "type" => 2,
            "name" => "message",
            "required" => true,
          ]);
        }
        \DB::commit();
      } catch (\Exception $e) {
        \DB::rollback();//Rollback to Data Base
        \Log::Error($e);
      }
      DB::table('isite__seeds')->insert(['name' => 'ContactFormTableSeeder']);
    }
  }
}
