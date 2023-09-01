<?php

return [
    'sidebar' => [
        'adminGroup' => 'Reservas',
        'adminCategories' => 'Categorias',
        'adminServices' => 'Servicios',
        'adminResources' => 'Recursos',
        'adminReservations' => 'Reservaciones',
        'panelUserResource' => 'Disponibilidad',
        'panelReservations' => 'Agenda',
        'panelNewReservation' => 'Nueva Reservación',
        'panelUpdateReservation' => 'Actualizar Reservación',
    ],
    'newCategory' => 'Nueva Categoría',
    'updateCategory' => 'Actualizar Categoría',
    'newService' => 'Nuevo Servicio',
    'updateService' => 'Actualizar Servicio',
    'newResource' => 'Nuevo Recurso',
    'updateResource' => 'Actualizar Recurso',
    'newReservation' => 'Nueva Reservación',
    'updateReservation' => 'Actualizar Reservación',
    'titleStepCategory' => '¿Que estás buscando?',
    'descriptionStepCategory' => 'Elige la categoría de tu interes',
    'titleStepService' => '¿Cuál servicio quieres?',
    'descriptionStepService' => 'Elige entre todos nuestros servicios',
    'titleStepResource' => '¿Tienes un favorito?',
    'descriptionStepResource' => 'Elige el que más prefieras',
    'titleStepDate' => '¿Cuándo quieres tu reserva?',
    'descriptionStepDate' => 'Elige la fecha y hora',
    'titleStepAvailability' => '¡Selecciona tu reserva!',
    'descriptionStepAvailability' => 'Selecciona la reserva de tu preferencía',
    'chooseDateReservation' => 'Elige el día para tu reserva',
    'chooseTimeReservation' => 'Elige la hora para tu reserva',
    'myResource' => 'Mi Recurso',
    'meetingPlatform' => 'Plataforma para reuniones',
    'registerZoom' => 'No tengo una cuenta de zoom',
    'termsZoom' => 'Cuando se le añade a la nueva cuenta de Zoom, la propiedad de su cuenta de Zoom existente (y la información contenida en ella) se transferirán y se asignarán al propietario de la nueva cuenta de Zoom. Toda la información y los datos actualmente contenidos en su cuenta de Zoom y toda la información o datos guardados una vez que acepte el cambio de cuenta, estarán visibles y disponibles para el propietario de la nueva cuenta de Zoom y los administradores en dicha cuenta para utilizarlos y compartirlos con otros sujetos a la discreción del dicho propietario de cuenta',
    'message' => [
        'meet' => [
            'notFound' => 'Ingresa tu cuenta de Zoom(email) para vincularte y poder crear reuniones...',
            'pending' => 'Falta poco! Revisa tu correo y acepta la vinculación para tu cuenta de Zoom...',
            'success' => 'Todo está listo! Nosotros nos encargamos de crear las reuniones en Zoom por ti...',
        ],
    ],
    'helpShareUserResource' => 'Puedes copiar los link de tus servicios y/o de tu recurso para compartirlos de una forma más facil',
    'documentation' => [
        'categories' => 'Es posible crear categories, con un nombre, descripción y organizarlas en modo de árbol
    (categorías padres y categorías hijas) con el fin de categorizar todos tus servicios.',
        'services' => 'Son los servicios los que tus usuarios pueden reservar dentro de tu aplicación, estos servicios incluyen
    el tiempo que puede durar cada turno y un precio ademas de toda la información necesaria para describirlo',
        'resources' => 'El recurso es el encargado de ejecutar un servicio reservado, cada recurso puede tener uno o varios
    servicios asignados pero puede realizar solo uno a la vez, en cada recurso es posible configurar un horario de 
    disponibilidad para que un servicio suyo pueda ser reservado.',
        'reservations' => "Cuando un usuario adquiere un servicio se le llama 'Reservación' así la aplicacion es capaz de
    identificar que servicio reservo un usuario junto a su recurso.",
    ],
];
