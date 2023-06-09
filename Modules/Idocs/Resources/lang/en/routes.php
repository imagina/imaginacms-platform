<?php

return [

    'documents' => [
        'index' => [
            'publicDocuments' => 'documents/public',
            'privateDocuments' => 'documents/private',
            'publicCategory' => 'documents/public/c/{categorySlug}',
            'privateCategory' => 'documents/private/c/{categorySlug}',
        ],
        'show' => [
            'document' => 'documents/download/{documentId}',
            'documentByKey' => 'documents/download/{documentId}/{documentKey}',
        ],
    ],
];
