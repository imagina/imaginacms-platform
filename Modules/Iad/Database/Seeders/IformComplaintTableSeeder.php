<?php

namespace Modules\Iad\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class IformComplaintTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Model::unguard();

        $formRepository = app("Modules\Iforms\Repositories\FormRepository");
        $blockRepository = app("Modules\Iforms\Repositories\BlockRepository");
        $fieldRepository = app("Modules\Iforms\Repositories\FieldRepository");
        $settingRepository = app("Modules\Setting\Repositories\SettingRepository");
        $locale = \LaravelLocalization::setLocale() ?: \App::getLocale();
        $params = [
            'filter' => [
                'field' => 'system_name',
            ],
            'include' => [],
            'fields' => [],
        ];
        $form = $formRepository->getItem('iad_complaint_form', json_decode(json_encode($params)));
        if (! isset($form->id)) {
            $form = $formRepository->create([
                'title' => trans('iad::fields.form.title.single'),
                'system_name' => 'iad_complaint_form',
                'active' => true,
            ]);

            $block = $blockRepository->create([
                'form_id' => $form->id,
            ]);

            $fieldRepository->create([
                'form_id' => $form->id,
                'block_id' => $block->id,
                'es' => [
                    'label' => trans('iad::fields.form.adName.label', [], 'es'),
                ],
                'en' => [
                    'label' => trans('iad::fields.form.adName.label', [], 'en'),
                ],
                'type' => 1,
                'name' => 'adName',
            ]);

            $fieldRepository->create([
                'form_id' => $form->id,
                'block_id' => $block->id,
                'es' => [
                    'label' => trans('iad::fields.form.complaint.label', [], 'es'),
                ],
                'en' => [
                    'label' => trans('iad::fields.form.complaint.label', [], 'en'),
                ],
                'type' => 2,
                'name' => 'complaint',
                'required' => true,
            ]);
            $settingRepository->createOrUpdate(['iad::complaintForm' => $form->id]);
        }
    }
}
