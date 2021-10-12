<meta name="description" content="@if(!empty($tag->description)){!!$tag->description!!}@endif">

<!-- Twitter Card -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:site" content="">
<meta name="twitter:title" content="{{$tag->title}}">
<meta name="twitter:description" content="{@if(!empty($tag->description)){!!$tag->description  !!}@endif">
<meta name="twitter:creator" content="">
<meta name="twitter:image:src"
      content="@if(!empty($tag->options->mainimage)){{url($tag->options->mainimage) }} @endif">
