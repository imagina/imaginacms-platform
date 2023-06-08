@extends("layouts.master")
@section('meta')
  <meta name="title" content="{{$item->meta_title??$item->title}}">
  <meta name="keywords" content="{{$item->meta_keyword ?? ''}}">
  <meta name="description" content="{{$item->meta_description??$item->description}}">

  <!-- Schema.org para Google+ -->
  <meta itemprop="name"
        content="{{$item->meta_title??$item->title}}">
  <meta itemprop="description"
        content="{{$item->meta_description??$item->description}}">
  <meta itemprop="image"
        content=" {{url($item->mediaFiles()->mainimage->path ?? 'modules/icommerce/img/product/default.jpg') }}">
  <!-- Open Graph para Facebook-->

  <meta property="og:title"
        content="{{$item->meta_title??$item->title}}"/>
  <meta property="og:type" content="article"/>
  <meta property="og:url" content="{{$item->url}}"/>
  <meta property="og:image"
        content="{{url($item->mediaFiles()->mainimage->path ?? 'modules/icommerce/img/product/default.jpg') }}"/>
  <meta property="og:description"
        content="{{$item->meta_description??$item->description}}"/>
  <meta property="og:site_name" content="{{Setting::get('core::site-name') }}"/>
  <meta property="og:locale" content="{{config('asgard.iblog.config.oglocal')}}">
  <!-- Twitter Card -->
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:site" content="{{ Setting::get('core::site-name') }}">
  <meta name="twitter:title"
        content="{{$item->meta_title??$item->title}}">
  <meta name="twitter:description"
        content="{{$item->meta_description??$item->description}}">
  <meta name="twitter:creator" content="">
  <meta name="twitter:image:src"
        content="{{url($item->mediaFiles()->mainimage->path ?? 'modules/icommerce/img/product/default.jpg') }}">

@stop

@section('content')
  <div class="page show show-pin show-pin-{{$pin->id ?? $item->id}}">
  @include("iad::frontend.partials.ad-item-show.layouts.".setting('iad::selectLayout').".index")
  </div>
  @stop
