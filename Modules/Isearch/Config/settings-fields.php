<?php

return [
  'minSearchChars' => [
    'name' => 'isearch::minSearchChars',
    'value' => '3',
    'type' => 'input',
    'columns' => 'col-12 col-md-6',
    'props' => [
      'label' => 'isearch::common.settings.minSearchChars',
      'clearable' => true,
      'type' => 'number',
    ],
  ],
  'repoSearch' => [
    'value' => json_encode(['Modules\Iblog\Repositories\CategoryRepository', 'Modules\Iblog\Repositories\PostRepository', 'Modules\Iplaces\Repositories\PlaceRepository',
      'Modules\Iad\Repositories\AdRepository', 'Modules\Icommerce\Repositories\ProductRepository']),
    'name' => 'isearch::repoSearch',
    'type' => 'select',
    'props' => [
      'label' => 'isearch::common.settings.search',
      'multiple' => true,
      'hideDropdownIcon' => true,
      'hint' => 'isearch::common.settingHints.search',
      'options' => [
        ['label' => 'Productos', 'value' => "Modules\Icommerce\Repositories\ProductRepository"],
        ['label' => 'Entradas', 'value' => "Modules\Iblog\Repositories\PostRepository"],
        ['label' => 'Categorias Blog', 'value' => "Modules\Iblog\Repositories\CategoryRepository"],
        ['label' => 'Anuncios', 'value' => "Modules\Iad\Repositories\AdRepository"],
        ['label' => 'Lugares', 'value' => "Modules\Iplaces\Repositories\PlaceRepository"],
        ['label' => 'Páginas', 'value' => "Modules\Page\Repositories\PageRepository"],
      ]
    ]
  ],
  'listOptionsSearch' => [
    'value' => null,
    'name' => 'isearch::listOptionsSearch',
    'type' => 'select',
    'props' => [
      'label' => 'isearch::common.settings.labelListOptionsSearch',
      'useInput' => true,
      'useChips' => true,
      'multiple' => true,
      'hideDropdownIcon' => true,
      'hint' => 'isearch::common.settingHints.hintsOptionsSearch',
      'newValueMode' => 'add-unique'
    ]
  ],
  'listFeaturedOptionsSearch' => [
    'value' => null,
    'name' => 'isearch::listFeaturedOptionsSearch',
    'type' => 'select',
    'props' => [
      'label' => 'isearch::common.settings.labelListFeaturedOptionsSearch',
      'useInput' => true,
      'useChips' => true,
      'multiple' => true,
      'hideDropdownIcon' => true,
      'hint' => 'isearch::common.settingHints.hintsFeaturedOptionsSearch',
      'newValueMode' => 'add-unique'
    ]
  ],
];
