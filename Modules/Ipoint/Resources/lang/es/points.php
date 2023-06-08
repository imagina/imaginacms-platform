<?php

return [
    'single' => 'Puntos',
    'description' => 'La descripcion del Modulo',
    'list resource' => 'Listar puntos',
    'create resource' => 'Crear puntos',
    'edit resource' => 'Editar puntos',
    'destroy resource' => 'Eliminar puntos',
    'title' => [
        'points' => 'Point',
        'create point' => 'Crear punto',
        'edit point' => 'Editar punto',
    ],
    'button' => [
        'create point' => 'Crear punto',
    ],
    'table' => [
    ],
    'form' => [
    ],
    'messages' => [
    ],
    'validation' => [
        'no point' => 'Puntos Insuficientes | Tus Puntos: :pointsUser - Puntos necesarios: :pointsItems |'
    ],
    'settings' => [
        'moneyForPoint' => 'Dinero por Punto (Equivalencia con el total de la Orden)',
        'roundPoints' => 'Redondear el Total de Puntos (Los que el Usuario ganará)',
    ],
    'settingHints' => [
        'moneyForPoint' => 'Ejemplo: Si el total de la orden es 10000, y cada punto tiene un valor de:1000, se ganarían: 10ptos',
        'roundPoints' => 'Ejemplo: Si el total de puntos es 7.5 se redondeara a 8 - Si no esta activo ganaría 7'
    ],
];
