
<meta name="description" content="{{$category->metadescription ?? "Te ofrecemos los mejores espacios para realizar tus eventos y fiestas temáticas. Tenemos todo lo que necesitas. Preparamos los mejores banquetes con cocina de autor y temática, canapés, repostería fina, bizcochos, cupcakes y cócteles para esta ocasión especial."}}">

<!-- Schema.org para Google+ -->
<meta itemprop="name" content="{{$category->metatitle ?? "Lugares"}}">
<meta itemprop="description" content="{{$category->metadescription ?? "Te ofrecemos los mejores espacios para realizar tus eventos y fiestas temáticas. Tenemos todo lo que necesitas. Preparamos los mejores banquetes con cocina de autor y temática, canapés, repostería fina, bizcochos, cupcakes y cócteles para esta ocasión especial."}}">
<meta itemprop="image" content=" {{$category->options->mainimage ?? Theme::url('img/logo.png') }} ">

<!-- Open Graph para Facebook-->
<meta property="og:title" content="{{$category->metatitle ?? "Lugares"}}" />
<meta property="og:type" content="categoria" />
<meta property="og:url" content="{{url($category->slug ?? "lugares")}}" />
<meta property="og:image" content="{{$category->options->mainimage ?? Theme::url('img/logo.png') }}" />
<meta property="og:description" content="{{$category->metadescription ?? 'Te ofrecemos los mejores espacios para realizar tus eventos y fiestas temáticas. Tenemos todo lo que necesitas. Preparamos los mejores banquetes con cocina de autor y temática, canapés, repostería fina, bizcochos, cupcakes y cócteles para esta ocasión especial.'}}" />
<meta property="og:site_name" content="" />
<meta property="og:locale" content="{{locale().'_CO'}}">

<!-- Twitter Card -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:site" content="">
<meta name="twitter:title" content="{{$category->metatitle ?? "Lugares"}}">
<meta name="twitter:description" content="{{$category->metadescription ?? 'Te ofrecemos los mejores espacios para realizar tus eventos y fiestas temáticas. Tenemos todo lo que necesitas. Preparamos los mejores banquetes con cocina de autor y temática, canapés, repostería fina, bizcochos, cupcakes y cócteles para esta ocasión especial.'}}">
<meta name="twitter:creator" content="">
<meta name="twitter:image:src" content="{{$category->options->mainimage ?? Theme::url('img/logo.png') }}">