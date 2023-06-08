@extends('layouts.master')

@section('meta')
  <meta name="description" content="{{$resource->description ?? ''}}">
  <!-- Schema.org para Google+ -->
  <meta itemprop="name" content="{{$resource->title}}">
  <meta itemprop="description" content="{{$resource->description ?? ''}}">
  <meta itemprop="image" content=" {{$resource->mediaFiles->mainimage->path}}">
  <!-- Open Graph para Facebook-->
  <meta property="og:title" content="{{$resource->title}}"/>
  <meta property="og:type" content="article"/>
  <meta property="og:image" content="{{$resource->mediaFiles->mainimage->path}}"/>
  <meta property="og:description" content="{{$resource->description}}"/>
  <meta property="og:site_name" content="{{Setting::get('core::site-name') }}"/>
  <!-- Twitter Card -->
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:site" content="{{ Setting::get('core::site-name') }}">
  <meta name="twitter:title" content="{{$resource->title}}">
  <meta name="twitter:description" content="{{$resource->description}}">
  <meta name="twitter:image:src" content="{{$resource->mediaFiles->mainimage->path}}">
@stop

@section('title')
  {{ $resource->title }} | @parent
@stop

@section('content')
  <div id="pageResourcesShow">
    <!--Resource Data-->
    <div class="bg-primary">
      <div class="container">
        <div id="resourceContent" class="row align-items-center">
          <!--Resource image-->
          <div id="resourceImageContent" class="col-xs-6 col-md-6 text-center">
            <x-media::single-image :alt="$resource->title" :title="$resource->title" :isMedia="true" zone="mainimage"
                                   :mediaFiles="$resource->mediaFiles" imgClasses="resource-image"/>
          </div>
          <!--Resource Data-->
          <div class="col-xs-6 col-md-6 text-center text-md-right">
            <div id="resourceTitle">{{$resource->title}}</div>
            <div id="resourceDescription" class="my-4">{{$resource->description}}</div>
            <!--Action-->
            <a type="button" class="btn btn-light"
               href="/ipanel/#/booking/reservations/create?resource={{$resource->id}}">
              {{trans('ibooking::reservations.button.reserve')}}
            </a>
          </div>
        </div>
      </div>
    </div>

    <!--Services-->
    <div id="servicesContent" class="container py-5">
      @foreach($resource->services as $service)
        <div class="service-content row align-items-center">
          <!--Description-->
          <div class="col-xs-12 col-md-6 text-center text-md-left">
            <div class="service-title">{{$service->title}}</div>
            <div class="service-description my-4">{!!$service->description!!}</div>
            <!--Action-->
            <a type="button" class="btn btn-primary"
               href="/ipanel/#/booking/reservations/create?resource={{$resource->id}}&service={{$service->id}}">
              {{trans('ibooking::reservations.button.reserve')}}
            </a>
          </div>
          <!--Image-->
          <div class="col-xs-12 col-md-6 text-center">
            <x-media::single-image :alt="$service->title" :title="$service->title" :isMedia="true" zone="mainimage"
                                   :mediaFiles="$service->mediaFiles" imgClasses="service-image"/>
          </div>
        </div>
      @endforeach
    </div>
  </div>
  <style>
    #pageResourcesShow #resourceContent {
      padding: 40px 0;
    }
    #pageResourcesShow #resourceContent #resourceTitle {
      color: white;
      font-size: 60px;
      line-height: 1;
    }
    #pageResourcesShow #resourceContent #resourceDescription {
      color: white;
      font-size: 30px;
      line-height: 1.2;
    }
    #pageResourcesShow #resourceContent .resource-image {
      padding: 15px;
      border: 2px solid white;
      border-radius: 10px;
      margin: 15px 0;
      width: 90%;
    }
    #pageResourcesShow #servicesContent .service-content {
      padding: 30px 0;
      border-bottom: 1px solid #d2d2d2;
    }
    #pageResourcesShow #servicesContent .service-content:last-child {
      border: none;
    }
    #pageResourcesShow #servicesContent .service-content .service-title {
      line-height: 1.2;
      font-weight: bold;
      font-size: 40px;
    }
    #pageResourcesShow #servicesContent .service-content .service-description {
      font-size: 20px;
      line-height: 1.2;
    }
    #pageResourcesShow #servicesContent .service-content .service-image {
      padding: 15px;
      border: 2px solid var(--primary);
      border-radius: 10px;
      margin: 25px 0;
      width: 90%;
    }

  </style>
@stop
