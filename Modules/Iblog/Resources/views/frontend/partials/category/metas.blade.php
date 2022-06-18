<meta name="description" content="{{strip_tags($category->description)}}">
<!-- Schema.org para Google+ -->
<meta itemprop="name" content="{{$category->meta_title ?? $category->title}}">
<meta itemprop="description" content="{{$category->meta_description ??  Str::limit(strip_tags($category->description),160)}}">
<meta itemprop="image" content=" {{url($category->mainImage->path) }}">
<!-- Open Graph para Facebook-->
<meta property="og:title" content="{{$category->meta_title ?? $category->title}}"/>
<meta property="og:type" content="article"/>
<meta property="og:url" content="{{$category->url}}"/>
<meta property="og:image" content="{{url($category->mainImage->path)}}"/>
<meta property="og:description" content="{{$category->meta_description ??  Str::limit( strip_tags($category->description),160)}}"/>
<meta property="og:site_name" content="{{Setting::get('core::site-name') }}"/>
<meta property="og:locale" content="{{config('asgard.iblog.config.oglocale')}}">

<!-- Twitter Card -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:site" content="{{ Setting::get('core::site-name') }}">
<meta name="twitter:title" content="{{$category->meta_title ?? $category->title}}">
<meta name="twitter:description" content="{{$category->meta_description ??  Str::limit(strip_tags($category->description),160)}}">
<meta name="twitter:creator" content="{{Setting::get('iblog::twitter') }}">
<meta name="twitter:image:src" content="{{url($category->mainImage->path)}}">