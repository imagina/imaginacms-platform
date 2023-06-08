@section('meta')
  @if(isset($category->id))

    @php
      if(isset($category->id)){
          $title = $category->meta_title ?? $category->title;
          $description = $category->meta_description ?? $category->description;

            $mediaFiles = $category->mediaFiles();
            $withImage = !strpos($mediaFiles->mainimage->path,"default.jpg");
            $image = $mediaFiles->mainimage->path;
            $url = $category->url;
            }
    @endphp

    <meta name="description" content="{{$description}}">
    <!-- Schema.org para Google+ -->
    <meta itemprop="name" content="{{$title}}">
    <meta itemprop="description" content="{{$description}}">

    @if($withImage)
      <meta itemprop="image" content=" {{url($image)}}">
      <meta property="og:image" content="{{url($image) }}"/>
      <meta name="twitter:image:src" content="{{url($image) }}">
    @endif
    <meta property="og:title"
          content="{{$title}}"/>
    <meta property="og:type" content="article"/>
    <meta property="og:url" content="{{$url}}"/>
    <meta property="og:description"
          content="{{$description}}"/>
    <meta property="og:site_name" content="{{Setting::get('core::site-name') }}"/>
    <meta property="og:locale" content="{{config('asgard.iblog.config.oglocal')}}">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="{{ Setting::get('core::site-name') }}">
    <meta name="twitter:title"
          content="{{$title}}">
    <meta name="twitter:description"
          content="{{$description}}">
    <meta name="twitter:creator" content="">
  @endif
@stop

@section('title')
  {{(isset($category->id)) ? ($category->title) : ucfirst(trans("iad::routes.ad.index.index"))}}  | @parent
@stop
