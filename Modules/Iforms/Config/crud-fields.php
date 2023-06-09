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
            'props' => [
                'hint' => 'iforms::fields.crudFields.hint.min',
                'label' => 'iforms::fields.crudFields.label.min',
            ],
        ],
        'max' => [
            'name' => 'max',
            'value' => [],
            'type' => 'input',
            'fakeFieldName' => 'rules',
            'columns' => 'col-12 col-md-6',
            'props' => [
                'hint' => 'iforms::fields.crudFields.hint.max',
                'label' => 'iforms::fields.crudFields.label.max',
            ],
        ],
        'maxlength' => [
            'name' => 'maxlength',
            'value' => [],
            'type' => 'input',
            'fakeFieldName' => 'rules',
            'columns' => 'col-12 col-md-6',
            'props' => [
                'hint' => 'iforms::fields.crudFields.hint.maxlength',
                'label' => 'iforms::fields.crudFields.label.maxlength',
            ],
        ],
        'mimes' => [
            'name' => 'mimes',
            'value' => [],
            'type' => 'select',
            'fakeFieldName' => 'rules',
            'columns' => 'col-12 col-md-6',
            'props' => [
                'useInput' => true,
                'useChips' => true,
                'multiple' => true,
                'hint' => 'iforms::fields.crudFields.hint.mimes',
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
            'props' => [
                'hint' => 'iforms::fields.crudFields.hint.entity',
                'label' => 'iforms::fields.crudFields.label.entity',
            ],
        ],
    ],
];
