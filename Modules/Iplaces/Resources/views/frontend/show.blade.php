@extends('layouts.master')

@section('meta')
    @include('iplaces::frontend.metadatashow')
@stop

@section('title')
    {{ $place->title }} | @parent
@stop

@section('content')
    @php
        $locale = \LaravelLocalization::setLocale() ?: App::getLocale();
    @endphp

    <div class="page blog single-iplace">
        <div class="container">
            <nav class="mt-3" aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent justify-content-end rounded-0 mb-0">
                    <li class="breadcrumb-item">
                        <a class="text-primary" href="{{url('/')}}">Inicio</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a class="text-primary" href="{{route($locale.'.iplaces.place.index')}}">
                            {{ trans('iplaces::common.iplaces') }}
                        </a>
                    </li>
                    <li class="breadcrumb-item active text-gray-color" aria-current="page">
                        {{$place->title}}
                    </li>
                </ol>
            </nav>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-12 header mb-4">
                    <h1 class="title mb-2">
                        {{$place->title}}
                    </h1>
                    {{$place->summary}}
                    <div class="rating mt-3">
                        @for ($i=1; $i <= 5; $i++)
                            <i class="fa fa-star pr-1 {{$place->rating>=$i ? '':'text-muted'}}"></i>
                        @endfor
                    </div>

                </div>
            </div>


            <div class="row">
                <div class="col-xl-9 mb-5">

                    @if(count(placegallery($place->id)) > 0)
                        @include('iplaces.widgets.gallery-images')
                    @else
                        <div class="img-gallery">
                            @if(isset($place->mainimage)&&!empty($place->mainimage))
                                <img class="img-fluid w-100" src="{{url($place->mainimage['path'])}}"
                                     alt="{{$place->title}}"/>
                            @endif
                        </div>
                    @endif


                    <div class="row mt-4 data-general">
                        <div class="col-6 col-sm-4 col-lg-2 d-flex my-3">
                            <div class="d-inline-block">
                                <h6><i class="fa fa-map-marker"></i> Ubicación:</h6>
                                {{$place->city->translate('es')->name}}, {{$place->province->translate('es')->name}}
                            </div>
                        </div>
                        <div class="col-6 col-sm-4 col-lg-2 d-flex my-3">
                            <img class="d-inline-block mr-2" src="{{Theme::url('img/icon/lugar.png')}}">

                            <div class="d-inline-block">
                                <h6>Tipo Lugar:</h6>
                                {{$place->zone->title ?? ''}}
                            </div>
                        </div>
                        <div class="col-6 col-sm-4 col-lg-2 d-flex my-3">
                            <div class="d-inline-block">
                                <h6><i class="fa fa-map-marker"></i> Capacidad:</h6>
                                {{$place->quantity_person}} invitados
                            </div>
                        </div>
                        <div class="col-6 col-sm-4 col-lg-2 d-flex my-3">
                            <img class="d-inline-block mr-2" src="{{Theme::url('img/icon/clima.png')}}">
                            <div class="d-inline-block">
                                <h6>Clima:</h6>
                                {{$place->present()->weather}}
                            </div>
                        </div>
                        @if ($place->housing==1)
                            <div class="col-6 col-sm-4 col-lg-2 d-flex my-3">
                                <img class="d-inline-block mr-2" src="{{Theme::url('img/icon/alojamiento.png')}}">
                                <div class="d-inline-block">
                                    <h6>Opción de
                                        Alojamiento</h6>
                                </div>
                            </div>
                        @endif
                        @if($place->transport==1)
                            <div class="col-6 col-sm-4 col-lg-2 d-flex my-3">
                                <img class="d-inline-block mr-2" src="{{Theme::url('img/icon/transporte.png')}}">
                                <div class="d-inline-block">
                                    <h6>Opción de
                                        Transporte</h6>
                                </div>
                            </div>
                        @endif
                    </div>

                    <hr>

                    <div class="row pt-3">
                     <div class="col-lg-5 pb-2">
                            @includeFirst(['iplaces::frontend.widgets.gallery-videos','iplaces.widgets.gallery-videos'])
                        </div>
                        <div class="col pb-2">
                            <h3 class="mb-3">Descripción</h3>
                            <div class="text-justify">
                                {!!$place->description !!}
                            </div>
                        </div>
                    </div>


                    @if(count($place->spaces))
                        <hr>
                        <h3>Espacios disponibles para eventos</h3>
                        <div class="row my-5">
                            @foreach($place->spaces as $space)
                                <div class="col-sm-12 col-md-6 mb-3 pl-5 d-flex">
                                    <i class="fa fa-check text-primary mr-2" aria-hidden="true"></i> {{$space->title}}
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <hr>



                    {{--<div class="my-4">
                        <h3>Sitios de referencia cercanos</h3>
                        <h5 class="text-primary my-2">{{$place->site->title}}</h5>
                        {!! $place->site->description!!}
                    </div>--}}

                    <hr>
                    @php
                        $principalServices= array();
                        $secondaryServices= array();
                         foreach($place->services as $service){
                         if ($service->servtype==0){
                         array_push($principalServices,$service);
                         }
                         else{
                         array_push($secondaryServices,$service);
                         }
                         }

                    @endphp
                    @if(count($principalServices))
                        <h3>Servicios</h3>
                        <div class="text-center my-4">

                            @foreach($principalServices as $service)
                                <div class="d-inline-grid mx-4 mb-4" style="width: 90px;">
                                    <img style="height: 90px;"
                                         class="img-fluid p-1 border border-primary rounded-circle"
                                         src="/assets/media/services-places/{{$service->slug}}.png">
                                    <h6 class="my-3">{{$service->title}}</h6>
                                </div>
                            @endforeach

                        </div>
                    @endif

                    @if(count($secondaryServices))
                        <h3>Otros servicios</h3>


                        <div class="row my-5">
                            @foreach($secondaryServices as $serviceSecondary)

                                <div class="col-sm-12 col-md-6 mb-3 pl-5 d-flex">
                                    <i class="fa fa-check text-primary mr-2" aria-hidden="true"></i>
                                    {{$serviceSecondary->title}}
                                </div>

                            @endforeach
                        </div>
                    @endif


                </div>

                <aside class="col-xl-3">

                    @includeFirst(['iplaces::frontend.widgets.availability','iplaces.widgets.availability'])

                    <a class=" btn-rounded border border-primary text-primary mx-auto my-3" href=""><i
                                class="fa fa-phone"></i> LLamar</a>

                </aside>
            </div>

        </div>


        @includeFirst(['iplaces::frontend.partials.map','iplaces.partials.map'])

        @includeFirst(['iplaces::frontend.partials.places','iplaces.partials.places'])

        {{--
        @include('partials.subscription')

        @include('partials.registration')
        --}}


    </div>
@stop

