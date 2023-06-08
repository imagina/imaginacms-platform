<?php
return [
    'crudFields' => [
        'url' => 'Enlace del plan'
    ],
    'settings' => [
        'default-plan-to-new-users' => 'Plan por defecto para nuevos usuarios',
        'enableQr' => 'Habilitar Código QR para los usuarios suscritos',
        'defaultPageDescription' => 'Descripción por defecto en la página de planes',
        'cumulativePlans' => 'Planes acumulativos',
        'hideDefaultPlanInView' => 'Ocultar plan por defecto en la vista de planes',
        'tenant' => [
          'group' => 'Inquilinos',
          'tenantWithCentralData' => 'Entidades con data central',
          'entities' => [
            'plans' => 'Planes',
          ],
        ],
    ],
    'settingHints' => [
        'default-plan-to-new-users' => 'Selecciona un plan por defecto para nuevos usuarios',
        'cumulativePlans' => 'Los limites de los planes anteriores (Si el usuario ya posee) no se desactivaran',
    ],
    'messages' => [
        'entity-create-not-allowed' => 'Creación/Actualización no Permitida',
        'user-valid-subscription' => 'El Usuario <b>:name</b>, posee al menos una (1) suscripción vigente.',
        'user-not-valid-subscription' => 'Lo sentimos. El usuario <b>:name</b>, no posee en el momento ninguna suscripción vigente.',
    ],
    'title' => [
        'my-qrs' => 'Mi Código QR',
        'my-subscriptions' => 'Mis Suscripciones',
        'print' => 'Imprimir',
    ],
    "planNotFound" => "El plan no es valido"
];
