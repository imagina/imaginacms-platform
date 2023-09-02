<?php

namespace Modules\Requestable\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class CreateFormTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Model::unguard();

        $formRepository = app("Modules\Iforms\Repositories\FormRepository");
        $blockRepository = app("Modules\Iforms\Repositories\BlockRepository");

        $params = [
            'filter' => ['field' => 'system_name'],
            'include' => [],
            'fields' => [],
        ];

        $systemName = 'lead';

        $form = $formRepository->getItem($systemName, json_decode(json_encode($params)));

        //Validation Form
        if (! isset($form->id)) {
            try {
                // Create Form
                $form = $formRepository->create([
                    'title' => trans('requestable::forms.lead.title'),
                    'system_name' => $systemName,
                    'active' => true,
                ]);

                $options['urlTermsAndConditions'] = null;

                // Create Block
                $block = $blockRepository->create([
                    'form_id' => $form->id,
                ]);

                // Create Field - Input
                $field = $this->createField($form->id, $block->id, 1, 'name', false, 'requestable::forms.lead.fields.name');

                // Create Field - Input
                $field = $this->createField($form->id, $block->id, 1, 'lastname', false, 'requestable::forms.lead.fields.lastname');

                // Create Field - Phone
                $field = $this->createField($form->id, $block->id, 10, 'telephone', false, 'requestable::forms.lead.fields.telephone');
                $options['replyToMobile'] = $field->id;

                // Create Field - Email
                $field = $this->createField($form->id, $block->id, 4, 'email', false, 'requestable::forms.lead.fields.email');
                $options['replyTo'] = $field->id;

                // Create Field - Text
                $field = $this->createField($form->id, $block->id, 2, 'comment', false, 'requestable::forms.lead.fields.comment');

                //Create Field - Text
                $field = $this->createField($form->id, $block->id, 1, 'value', false, 'requestable::forms.lead.fields.value');

                //Update form with options
                $form->options = $options;
                $form->save();

                $this->createCategoryAndStatusesFromConfig($form);
            } catch(\Exception $e) {
                \Log::error('Requestable: Seeders|CreateForm|Message: '.$e->getMessage());
            }
        }
    }

    /*
    * Create Category and Status
    */
    public function createCategoryAndStatusesFromConfig($form)
    {
        $config = config('asgard.requestable.config.requestable-leads');

        $config['formId'] = $form->id;

        // Call requestable
        $requestableService = app("Modules\Requestable\Services\RequestableService");

        $requestableService->createFromConfig($config);
    }

    /*
    * Create Field
    */
    public function createField($formId, $blockId, $type, $name, $required, $label)
    {
        $fieldRepository = app("Modules\Iforms\Repositories\FieldRepository");

        $dataToCreate = [
            'form_id' => $formId,
            'block_id' => $blockId,
            'type' => $type,
            'name' => $name,
            'required' => $required,
        ];

        // Create Field
        $fieldCreated = $fieldRepository->create($dataToCreate);

        //Translations
        $this->addTranslation($fieldCreated, 'es', $label);
        $this->addTranslation($fieldCreated, 'en', $label);

        return $fieldCreated;
    }

    /*
    * Add Translations
    * PD: New Alternative method due to problems with astronomic translatable
    **/
    public function addTranslation($field, $locale, $label)
    {
        \DB::table('iforms__field_translations')->insert([
            'label' => trans($label, [], $locale),
            'field_id' => $field->id,
            'locale' => $locale,
        ]);
    }
}
