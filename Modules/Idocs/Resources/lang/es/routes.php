<?php

return [
    
    'documents' => [
      'index' => [
        'publicDocuments' => "documentos/publicos",
        'privateDocuments' => "documentos/privados",
        'publicCategory' => "documentos/publicos/c/{categorySlug}",
        'privateCategory' => "documentos/privados/c/{categorySlug}",
      ],
      
      'show' => [
        'document' => 'documentos/descarga/{documentId}',
        'documentByKey' => 'documentos/descarga/{documentId}/{documentKey}',
      ]
    ]
    
];
