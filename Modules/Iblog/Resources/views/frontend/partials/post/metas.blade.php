<meta name="description" content="{{$post->summary}}">
<!-- Schema.org para Google+ -->
<meta itemprop="name" content="{{$post->title}}">
<meta itemprop="description" content="{{$post->summary}}">
<meta itemprop="image" content=" {{url($post->mainimage->path) }}">
<!-- Open Graph para Facebook-->
<meta property="og:title" content="{{$post->title}}"/>
<meta property="og:type" content="article"/>
<meta property="og:url" content="{{$post->url}}"/>
<meta property="og:image" content="{{url($post->mainimage->path)}}"/>
<meta property="og:description" content="{{$post->summary}}"/>
<meta property="og:site_name" content="{{Setting::get('core::site-name') }}"/>
<meta property="og:locale" content="{{config('asgard.iblog.config.oglocale')}}">

<!-- Twitter Card -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:site" content="{{ Setting::get('core::site-name') }}">
<meta name="twitter:title" content="{{$post->title}}">
<meta name="twitter:description" content="{{$post->summary}}">
<meta name="twitter:creator" content="{{Setting::get('iblog::twitter') }}">
<meta name="twitter:image:src" content="{{url($post->mainimage->path)}}">