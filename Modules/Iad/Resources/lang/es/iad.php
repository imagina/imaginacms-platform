<?php

return [
  "name" => "Anuncios",
  "requestable" => [
    "requestCheckAd" => "Verificar anuncio",
    "notifyNewRequest" => [
      "title" => 'Nueva Petición',
      "message" => 'Tienes una nueva petición para verificar un anuncio',
      "viewRequests" => 'Ver solicitudes'
    ],
    "notifyUpdateRequest" => [
      "title" => 'Verificación de anuncio',
      "message" => 'Tu solicitud de verificación de anuncio se ha actualizado, estado: :status',
      "viewRequests" => 'Ver solicitudes'
    ]
  ],
  "settings" => [
    'allowRequestForChecked' => 'Permitir petición para verificar anuncio'
  ]
];
