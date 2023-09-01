<?php

return [
    'limitPostsRss' => [
        'name' => 'ifeed::limitPostsRss',
        'value' => 500,
        'type' => 'select',
        'groupName' => 'rss',
        'groupTitle' => 'ifeed::feed.rss.groupName',
        'props' => [
            'label' => 'ifeed::feed.rss.labelLimitPostsRss',
            'options' => [
                ['label' => '500', 'value' => 500],
                ['label' => '200', 'value' => 200],
                ['label' => '10', 'value' => 10],
                ['label' => '100', 'value' => 100],
                ['label' => '300', 'value' => 300],
            ],
        ],
    ],
    'limitProductsRss' => [
        'name' => 'ifeed::limitProductsRss',
        'value' => 500,
        'type' => 'select',
        'groupName' => 'rss',
        'groupTitle' => 'ifeed::feed.rss.groupName',
        'props' => [
            'label' => 'ifeed::feed.rss.labelLimitProductsRss',
            'options' => [
                ['label' => '500', 'value' => 500],
                ['label' => '200', 'value' => 200],
                ['label' => '10', 'value' => 10],
                ['label' => '100', 'value' => 100],
                ['label' => '300', 'value' => 300],
            ],
        ],
    ],
];
