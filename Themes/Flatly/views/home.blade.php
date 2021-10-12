@extends('layouts.master')

@section('title')
    {{ $page->title }} | @parent
@stop
@section('meta')
    <meta name="title" content="{{$page->meta_title ?? $page->title ?? setting('core::site-name')}} "/>
    <meta name="description" content="{{$page->meta_description ?? strip_tags($page->body) ?? setting('core::site-description') }}"/>
    <!-- Schema.org para Google+ -->
    <meta itemprop="name" content="{{$page->meta_title ?? $page->title}}">
    <meta itemprop="description" content="{{$page->meta_description ?? strip_tags($page->body)?? setting('core::site-description') }}">
    <meta itemprop="image" content="{{url($page->image->path??'')}}">
    <!-- Open Graph para Facebook-->
    <meta property="og:title" content="{{$page->og_title??$page->meta_title  ?? $page->title ?? setting('core::site-name')}}  "/>
    <meta property="og:type" content="{{$page->og_image??'website'}}"/>
    <meta property="og:url" content="{{canonical_url()}}"/>
    <meta property="og:image" content="{{url($page->og_image??$page->image->path??'')}}"/>
    <meta property="og:description" content="{{$page->og_description??$page->meta_description ??strip_tags($page->body) ?? setting('core::site-description') }}"/>
    <meta property="og:site_name" content="{{Setting::get('core::site-name') }}"/>
    <meta property="og:locale" content="{{config('asgard.iblog.config.oglocale')}}">
    <meta property="fb:app_id" content="290785397747585">
    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="{{ Setting::get('core::site-name') }}">
    <meta name="twitter:title" content="{{$page->meta_title  ?? $page->title ?? setting('core::site-name')}} ">
    <meta name="twitter:description" content="{{$page->meta_description ?? strip_tags($page->body) ?? setting('core::site-description') }}">
    <meta name="twitter:creator" content="{{Setting::get('iblog::twitter') }}">
    <meta name="twitter:image:src" content="{{url($page->image->path??'')}}">
@stop

