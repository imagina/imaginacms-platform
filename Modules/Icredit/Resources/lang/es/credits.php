<?php

return [
    'list resource' => 'Lista creditos',
    'create resource' => 'Crear creditos',
    'edit resource' => 'Editar creditos',
    'destroy resource' => 'Eliminar creditos',
    'title' => [
        'credits' => 'Créditos',
        'create credit' => 'Crear un credito',
        'edit credit' => 'Editar un credito',
        'WithdrawalFundsRequestInProgress' => 'Tu solicitud de retiro de fondos Nro. :requestableId  se encuentra en estado de progreso',
        'WithdrawalFundsRequestWasCreated' => 'Tiene un nueva solicitud de retiro de fondos',
        'WithdrawalFundsRequestWasAccepted' => 'Su solicitud para retirar fondos ha sido aprobada',
        'WithdrawalFundsRequestWasRejected' => 'Su solicitud para retirar fondos ha sido rechazada',
    ],
    'description' => 'La descripcion del Modulo',
    'button' => [
        'create credit' => 'Crear un credito',
    ],
    'table' => [
    ],
    'form' => [
    ],
    'settings' => [
        'icreditWithdrawalFundsForm' => 'Formulario de retiro de fondos',
        'creditAmountCustomService' => 'Servicio custom para monto a la wallet',
    ],
    'messages' => [
        'WithdrawalFundsRequestInProgress' => 'Tu solicitud se encuentra en progreso, te notificaremos cuando se culmine todo el proceso',
        'WithdrawalFundsRequestWasCreated' => 'Tiene una nueva solicitud de retiro de fondos por parte de cliente :requestUserName identificado con cedula numero :requestableId, por un valor de :requestAmount',
        'WithdrawalFundsRequestWasAccepted' => 'Su solicitud de retiro de fondos Nro. :requestableId ha sido aprobada, ¡Qué bien!',
        'WithdrawalFundsRequestWasAcceptedWithETA' => 'Su solicitud de retiro de fondos Nro. :requestableId ha sido aprobada, y lo tendrás disponible para la fecha :requestableETA, ¡Qué bien!',
        'WithdrawalFundsRequestWasRejected' => 'Su solicitud para retirar fondos Nro. :requestableId, ha sido rechazada para mayor informaccion comunicarce al :emailTo',
    ],
    'validation' => [
    ],
    'descriptions' => [
        'orderWasCreated' => 'Credito aplicado por la orden Nro. :orderId',
        'WithdrawalFundsRequestWasEffected' => 'Retiro efectivo aplicado por la solicitud Nro. :requestableId',
        'WithdrawalFundsRequestWasCreated' => 'Solicitud de Retiro de fondos Nro. :requestableId',
        'WithdrawalFundsRequestWasRejected' => 'Retiro de fondos Rechazado',
    ],

    'withdrawalFundsForm' => [
        'requestable' => [
            'title' => 'Retiro de Fondos',
        ],
        'form' => [
            'title' => [
                'single' => 'Formulario de retiro de fondos',
            ],
            'fields' => [
                'amount' => 'Monto',
            ],
        ],
    ],

    'status' => [
        'pending' => 'Pendiente',
        'approved' => 'Aprobado',
        'canceled' => 'Cancelado',
    ],

];
