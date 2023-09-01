<?php

namespace Modules\Isite\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\Iforms\Events\SyncFormeable;
use Modules\Iprofile\Entities\Role;

class IformOrganizationDefaultRegisterTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Model::unguard();

        $rolesToTenant = json_decode(setting('isite::rolesToTenant', null, '[]'));

        if (! empty($rolesToTenant)) {
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
            $form = $formRepository->getItem('iform_organization_default_register', json_decode(json_encode($params)));
            if (! isset($form->id)) {
                $form = $formRepository->create([
                    'title' => trans('isite::forms.organizationDefaultRegister.title'),
                    'system_name' => 'iform_organization_default_register',
                    'active' => true,
                ]);

                $fieldsBlock = $blockRepository->create([
                    'form_id' => $form->id,
                    'name' => 'fields',
                ]);

                $fieldRepository->create([
                    'form_id' => $form->id,
                    'block_id' => $fieldsBlock->id,
                    'es' => [
                        'label' => trans('isite::forms.organizationDefaultRegister.fields.firstName', [], 'es'),
                    ],
                    'en' => [
                        'label' => trans('isite::forms.organizationDefaultRegister.fields.firstName', [], 'en'),
                    ],
                    'type' => 1,
                    'name' => 'firstName',
                    'required' => true,
                ]);

                $fieldRepository->create([
                    'form_id' => $form->id,
                    'block_id' => $fieldsBlock->id,
                    'es' => [
                        'label' => trans('isite::forms.organizationDefaultRegister.fields.lastName', [], 'es'),
                    ],
                    'en' => [
                        'label' => trans('isite::forms.organizationDefaultRegister.fields.lastName', [], 'en'),
                    ],
                    'type' => 1,
                    'name' => 'lastName',
                    'required' => true,
                ]);

                $fieldRepository->create([
                    'form_id' => $form->id,
                    'block_id' => $fieldsBlock->id,
                    'es' => [
                        'label' => trans('isite::forms.organizationDefaultRegister.fields.birthday', [], 'es'),
                    ],
                    'en' => [
                        'label' => trans('isite::forms.organizationDefaultRegister.fields.birthday', [], 'en'),
                    ],
                    'type' => 11,
                    'name' => 'birthday',
                    'required' => false,
                ]);

                $fieldRepository->create([
                    'form_id' => $form->id,
                    'block_id' => $fieldsBlock->id,
                    'es' => [
                        'label' => trans('isite::forms.organizationDefaultRegister.fields.documentType', [], 'es'),
                    ],
                    'en' => [
                        'label' => trans('isite::forms.organizationDefaultRegister.fields.documentType', [], 'en'),
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
                    'block_id' => $fieldsBlock->id,
                    'es' => [
                        'label' => trans('isite::forms.organizationDefaultRegister.fields.documentNumber', [], 'es'),
                    ],
                    'en' => [
                        'label' => trans('isite::forms.organizationDefaultRegister.fields.documentNumber', [], 'en'),
                    ],
                    'type' => 3,
                    'name' => 'documentNumber',
                    'required' => true,
                ]);

                $organizationBlock = $blockRepository->create([
                    'form_id' => $form->id,
                    'name' => 'organization',
                ]);

                $fieldRepository->create([
                    'form_id' => $form->id,
                    'block_id' => $organizationBlock->id,
                    'es' => [
                        'label' => trans('isite::forms.organizationDefaultRegister.organization.title', [], 'es'),
                    ],
                    'en' => [
                        'label' => trans('isite::forms.organizationDefaultRegister.organization.title', [], 'en'),
                    ],
                    'type' => 1,
                    'name' => 'title',
                    'required' => true,
                ]);

                $fieldRepository->create([
                    'form_id' => $form->id,
                    'block_id' => $organizationBlock->id,
                    'es' => [
                        'label' => trans('isite::forms.organizationDefaultRegister.organization.category', [], 'es'),
                    ],
                    'en' => [
                        'label' => trans('isite::forms.organizationDefaultRegister.organization.category', [], 'en'),
                    ],
                    'type' => 13,
                    'name' => 'categoryId',
                    'options' => [
                        'loadOptions' => [
                            'apiRoute' => '/isite/v1/categories',
                            'select' => ['label' => 'title', 'id' => 'id'],
                        ],
                    ],
                    'required' => true,
                ]);

                foreach ($rolesToTenant as $role) {
                    $role = Role::find($role);
                    event(new SyncFormeable($role, ['form_id' => $form->id]));
                }
            }
        }
    }
}
