<meta name="description" content="{{strip_tags($category->description??'lista de documentos ')}}">
<!-- Schema.org para Google+ -->
<meta itemprop="name" content="{{$category->title??trans('idocs::common.title.idocs')}}">
<meta itemprop="description" content="{{strip_tags($category->description??'lista de documentos ')}}">
<meta itemprop="image" content=" {{url($category->mainImage->path??'') }}">
<!-- Open Graph para Facebook-->
<meta property="og:title" content="{{$category->title??trans('idocs::common.title.idocs')}}"/>
<meta property="og:type" content="article"/>
<meta property="og:url" content="{{$category->url??''}}"/>
<meta property="og:image" content="{{url($category->mainImage->path??'')}}"/>
<meta property="og:description" content="{{strip_tags($category->description??'lista de documentos ')}}"/>
<meta property="og:site_name" content="{{Setting::get('core::site-name') }}"/>
<meta property="og:locale" content="{{config('asgard.idocs.config.oglocale')}}">

<!-- Twitter Card -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:site" content="{{ Setting::get('core::site-name') }}">
<meta name="twitter:title" content="{{$category->title??trans('idocs::common.title.idocs')}}">
<meta name="twitter:description" content="{{strip_tags($category->description??'lista de documentos ')}}">
<meta name="twitter:creator" content="{{Setting::get('idocs::twitter') }}">
<meta name="twitter:image:src" content="{{url($category->mainImage->path??'')}}">