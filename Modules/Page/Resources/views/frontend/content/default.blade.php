@extends('layouts.master')

@section('title')
  {{ $page->title }} | @parent
@stop

@section('meta')
  <meta name="title" content="{{ $page->meta_title}}"/>
  <meta name="description" content="{{ $page->meta_description }}"/>
@stop

@section('content')
  <div class="page page-default" data-icontenttype="page">
    <!--Banner page title-->
    <div class="bg-primary text-white py-5 mb-5 text-center">
      <h1 class="h3 py-3">{{$page->title}}</h1>
    </div>
    <!---Body-->
    <div class="container">
      {!! $page->body !!}
    </div>
  </div>
@endsection
