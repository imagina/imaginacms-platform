<?php

return [
    'forms' => [
        'customLeadPDFTemplate' => [
            'name' => 'customLeadPDFTemplate',
            'value' => '',
            'type' => 'input',
            'fakeFieldName' => 'options',
            'columns' => 'col-12 col-md-6',
            'props' => [
                'label' => 'iforms::forms.form.customLeadPDFTemplate',
            ],
        ],
    ],
    'fields' => [

        // RULES

        'min' => [
            'name' => 'min',
            'value' => [],
            'type' => 'input',
            'fakeFieldName' => 'rules',
            'columns' => 'col-12 col-md-6',
      'help' => [
        'description' => 'iforms::fields.crudFields.hint.min',
      ],
            'props' => [
        'label' => 'iforms::fields.crudFields.label.min'
            ],
        ],
        'max' => [
            'name' => 'max',
            'value' => [],
            'type' => 'input',
            'fakeFieldName' => 'rules',
            'columns' => 'col-12 col-md-6',
      'help' => [
        'description' => 'iforms::fields.crudFields.hint.max',
      ],
            'props' => [
        'label' => 'iforms::fields.crudFields.label.max'
            ],
        ],
        'maxlength' => [
            'name' => 'maxlength',
            'value' => [],
            'type' => 'input',
            'fakeFieldName' => 'rules',
            'columns' => 'col-12 col-md-6',
      'help' => [
        'description' => 'iforms::fields.crudFields.hint.maxlength',
      ],
            'props' => [
        'label' => 'iforms::fields.crudFields.label.maxlength'
            ],
        ],
        'mimes' => [
            'name' => 'mimes',
            'value' => [],
            'type' => 'select',
            'fakeFieldName' => 'rules',
            'columns' => 'col-12 col-md-6',
      'help' => [
        'description' => 'iforms::fields.crudFields.hint.mimes',
      ],
            'props' => [
                'useInput' => true,
                'useChips' => true,
                'multiple' => true,
                'hideDropdownIcon' => true,
                'newValueMode' => 'add-unique',
                'label' => 'iforms::fields.crudFields.label.mimes',
            ],
        ],
        'entity' => [
            'name' => 'entity',
            'value' => [],
            'type' => 'input',
            'fakeFieldName' => 'options',
            'columns' => 'col-12 col-md-6',
      'help' => [
        'description' => 'iforms::fields.crudFields.hint.entity',
      ],
            'props' => [
        'label' => 'iforms::fields.crudFields.label.entity'
            ],
        ],
    ],
];
