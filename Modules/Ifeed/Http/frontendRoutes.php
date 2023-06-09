<?php

use Illuminate\Routing\Router;

//Router::feeds();
$url = url('/');
$url = str_replace('https://', '', $url);
config(['feed.feeds.posts.title' => trans('ifeed::feeds.title.titlePosts').$url]);
config(['feed.feeds.products.title' => trans('ifeed::feeds.title.titleProducts').$url]);
