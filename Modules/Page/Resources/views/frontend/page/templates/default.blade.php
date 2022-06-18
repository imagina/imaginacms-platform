@extends('page::frontend.page.layouts.default')

@section('title')
    {{ $page->title }} | @parent
@stop
@section('meta')
    @parent
    @include("page::frontend.partials.metas")
@stop

@section('content')
    @include($pageContent)

@stop
