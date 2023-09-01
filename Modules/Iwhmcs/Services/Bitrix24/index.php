<?php

require_once __DIR__.'/crest.php';

$result = CRest::call(
    'crm.lead.get',
    ['ID' => '42']
);

echo '<pre>';
print_r($result);
echo '</pre>';
