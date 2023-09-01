<?php

if (! function_exists('get_document')) {
    function get_document($options = [])
    {
        $document = app('Modules\Idocs\Repositories\DocumentRepository');
        $params = json_decode(json_encode(['filter' => $options, 'include' => ['user', 'categories', 'category'], 'take' => $options['take'], 'skip' => $options['skip']]));

        return $document->getItemsBy($params);
    }
}
if (! function_exists('get_idocs_category')) {
    function get_idocs_category($options = [])
    {
        $category = app('Modules\Idocs\Repositories\CategoryRepository');
        $params = json_decode(json_encode(['filter' => $options, 'include' => [], 'take' => $options['take'] ?? '5', 'skip' => $options['skip'] ?? '5']));

        return $category->getItemsBy($params);
    }
}
