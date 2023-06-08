<meta name="description" content="{!! $place->metadescription !!}">

<!-- Schema.org para Google+ -->
<meta itemprop="name" content="{{$place->metatilte}}">
<meta itemprop="description" content="{{ $place->metadescription }}">
<meta itemprop="image" content=" {{url($place->options->mainimage ?? '') }}">

<!-- Open Graph para Facebook-->
<meta property="og:title" content="{{$place->metatilte}}"/>
<meta property="og:type" content="articulo"/>
<meta property="og:url" content="{{url($place->slug)}}"/>
<meta property="og:image" content="{{url($place->options->mainimage ?? '')}}"/>
<meta property="og:description" content="{!! $place->metadescription !!}"/>
<meta property="og:site_name" content="{{ Setting::get('core::site-name') }}"/>
<meta property="og:locale" content="{{locale().'_CO'}}">

<!-- Twitter Card -->
<meta name="twitter:card" content="metadescription_large_image">
<meta name="twitter:site" content="{{ Setting::get('core::site-name') }}">
<meta name="twitter:title" content="{{$place->metatilte}}">
<meta name="twitter:description" content="{{$place->metadescription }}">
<meta name="twitter:creator" content="">
<meta name="twitter:image:src" content="{{url($place->options->mainimage ?? '')}}">