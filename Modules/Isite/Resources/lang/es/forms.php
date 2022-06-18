<?php

return [
  
  "userDefaultRegister" => [
    'title' => "Formulario de Registro por defecto para el role User",
    'fields' => [
      "firstName" => "Nombre",
      "lastName" => "Apellido",
      "birthday" => "Fecha de Nacimiento",
      "documentType" => "Tipo de documento",
      "documentNumber" => "Número de documento",
    ]
  ],
  "organizationDefaultRegister" => [
    'title' => "Formulario de Registro por defecto para una organización",
    'fields' => [
      "firstName" => "Nombre",
      "lastName" => "Apellido",
      "birthday" => "Fecha de Nacimiento",
      "documentType" => "Tipo de documento",
      "documentNumber" => "Número de documento",
    ],
    'organization' => [
      "category" => "Categoría",
      "title" => "Nombre de la Organización",
      
    ]
  ]
  
];
