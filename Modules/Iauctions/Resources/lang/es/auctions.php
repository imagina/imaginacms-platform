<?php

return [
    'single' => 'Licitación',
    'plural' => 'Licitaciones',
    'list resource' => 'List auctions',
    'create resource' => 'Create auctions',
    'edit resource' => 'Edit auctions',
    'destroy resource' => 'Destroy auctions',
    'title' => [
        'auctions' => 'Auction',
        'create auction' => 'Create a auction',
        'edit auction' => 'Edit a auction',
        'AuctionWasCreated' => 'Se ha creado la Licitación #:auctionId',
        'AuctionWasActived' => 'Ha iniciado Licitación #:auctionId',
        'AuctionWasCanceled' => 'Se ha cancelado la Licitación #:auctionId',
        'AuctionWasFinished' => 'Ha finalizado la Licitación #:auctionId',
        'AuctionRemainingDay' => 'Falta 1 dia para que inicie la Licitación #:auctionId',
        'AuctionRemainingHour' => 'Falta 1 hora para que finalice la Licitación #:auctionId',
        'WinnerWasSelected' => 'Se ha seleccionado el ganador de la Licitación #:auctionId',
    ],
    'button' => [
        'create auction' => 'Create a auction',
    ],
    'table' => [
    ],
    'form' => [
    ],
    'messages' => [
        'AuctionWasCreated' => 'Licitación #:auctionId - :title - Inicia:
        :startAt | Culmina: :endAt',
        'AuctionWasActived' => 'Licitación #:auctionId - :title | Culmina: :endAt',
        'AuctionWasFinished' => 'Licitación #:auctionId - :title - Finalizada',
        'AuctionWasCanceled' => 'Licitación #:auctionId - :title - Cancelada',
        'AuctionRemainingDay' => 'Licitación #:auctionId - :title - Inicia:
        :startAt | Culmina: :endAt',
        'AuctionRemainingHour' => 'Licitación #:auctionId - :title | Culmina: :endAt',
        'WinnerWasSelected' => 'El ganador de la Licitación #:auctionId - :title | Es :bidWinner, Felicidades!',
    ],
    'validation' => [
        'not found' => 'Licitacion no existe',
        'not available' => 'Licitacion no disponible',
        'other bid' => 'Ya tienes una puja para esta Licitacion',
        'other winner' => 'Ya existe un ganador para esta Licitacion',
        'type not open' => 'La licitacion no es de tipo abierta',
        'not finished' => 'La licitacion no ha terminado',
        'has a winner' => 'La licitacion ya tiene un ganador',
        'has to be inactive to update' => 'La licitacion debe estar Pendiente para poder actualizarla',
        'only update status' => 'Solo se puede actualizar el estado de la Licitación',
    ],
    'status' => [
        'pending' => 'Pendiente',
        'active' => 'Activo',
        'finished' => 'Culminado',
        'canceled' => 'Cancelado',
    ],
    'types' => [
        'inverse' => 'Inversa',
        'open' => 'Abierto',
    ],
];
