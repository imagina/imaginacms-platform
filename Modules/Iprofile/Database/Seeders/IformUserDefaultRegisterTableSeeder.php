<?php

namespace Modules\Iprofile\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\Iforms\Events\SyncFormeable;
use Modules\Iprofile\Entities\Role;

class IformUserDefaultRegisterTableSeeder extends Seeder
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
        $form = $formRepository->getItem('iform_user_default_register', json_decode(json_encode($params)));
        if (! isset($form->id)) {
            $form = $formRepository->create([
                'title' => trans('isite::forms.userDefaultRegister.title'),
                'system_name' => 'iform_user_default_register',
                'active' => true,
            ]);

            $block = $blockRepository->create([
                'form_id' => $form->id,
                'name' => 'fields',
            ]);

            $fieldRepository->create([
                'form_id' => $form->id,
                'block_id' => $block->id,
                'es' => [
                    'label' => trans('isite::forms.userDefaultRegister.fields.firstName', [], 'es'),
                ],
                'en' => [
                    'label' => trans('isite::forms.userDefaultRegister.fields.firstName', [], 'en'),
                ],
                'type' => 1,
                'name' => 'firstName',
                'required' => true,
            ]);

            $fieldRepository->create([
                'form_id' => $form->id,
                'block_id' => $block->id,
                'es' => [
                    'label' => trans('isite::forms.userDefaultRegister.fields.lastName', [], 'es'),
                ],
                'en' => [
                    'label' => trans('isite::forms.userDefaultRegister.fields.lastName', [], 'en'),
                ],
                'type' => 1,
                'name' => 'lastName',
                'required' => true,
            ]);

            $fieldRepository->create([
                'form_id' => $form->id,
                'block_id' => $block->id,
                'es' => [
                    'label' => trans('isite::forms.userDefaultRegister.fields.birthday', [], 'es'),
                ],
                'en' => [
                    'label' => trans('isite::forms.userDefaultRegister.fields.birthday', [], 'en'),
                ],
                'type' => 11,
                'name' => 'birthday',
                'required' => false,
            ]);

            $fieldRepository->create([
                'form_id' => $form->id,
                'block_id' => $block->id,
                'es' => [
                    'label' => trans('isite::forms.userDefaultRegister.fields.documentType', [], 'es'),
                ],
                'en' => [
                    'label' => trans('isite::forms.userDefaultRegister.fields.documentType', [], 'en'),
                ],
                'options' => [
                    'fieldOptions' => [
                        'Cédula de Ciudadanía',
                        'Cédula de Extranjería',
                        'Número de Pasaporte',
                    ],
                ],
                'type' => 5,
                'name' => 'documentType',
                'required' => false,
            ]);

            $fieldRepository->create([
                'form_id' => $form->id,
                'block_id' => $block->id,
                'es' => [
                    'label' => trans('isite::forms.userDefaultRegister.fields.documentNumber', [], 'es'),
                ],
                'en' => [
                    'label' => trans('isite::forms.userDefaultRegister.fields.documentNumber', [], 'en'),
                ],
                'type' => 3,
                'name' => 'documentNumber',
                'required' => true,
            ]);

            $user = Role::where('slug', 'user')->first();

            event(new SyncFormeable($user, ['form_id' => $form->id]));
        }
    }
}
