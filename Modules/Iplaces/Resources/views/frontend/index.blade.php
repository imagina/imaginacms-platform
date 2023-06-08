@extends('layouts.master')

@section('meta')

    @if(isset($category->title) && !empty($category->title))
        @include('iplaces::frontend.metadatacategory')
    @else
        @include('iplaces::frontend.metadataindex')
    @endif
@stop

@section('title')
  {{ $category->title ?? trans('iplaces::common.iplaces') }} | @parent
@stop



@section('content')

    <div id="places-category"
         class="page blog-category-lugares">
        <div class="container">
            <nav class="mt-3" aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent justify-content-end rounded-0 mb-0">
                    <li class="breadcrumb-item">
                        <a class="text-primary" href="{{url('/')}}">Inicio</a>
                    </li>
                    <li class="breadcrumb-item active text-gray-color" aria-current="page">
                        @if(isset($category->title) && !empty($category->title))
                            {{$category->title}}
                        @else
                            {{ trans('iplaces::common.iplaces') }}
                        @endif
                    </li>
                </ol>
            </nav>
        </div>

        <div class="page-content container pb-3 pl-lg-0 mt-lg-2">
            <h2 class="places-title text-gray-dark mb-3">
                @if(isset($category->title) && !empty($category->title))
                    {{$category->title}}
                @else
                    {{ trans('iplaces::common.iplaces') }}
                @endif
            </h2>
        </div>



        <div class="container pl-lg-0">
            <div class="row">
                {{-- Sidebar --}}
                <div class="sidebar {{config('asgard.iplaces.config.customClassesToTheIndexCols.sidebar')}}">
                    {{-- Custom Includes --}}
                    @if(config("asgard.iplaces.config.customIncludesBeforeFilters"))
                        @foreach(config("asgard.iplaces.config.customIncludesBeforeFilters") as $view)
                            @include($view)
                        @endforeach
                    @endif
                    <livewire:isite::filters :filters="config('asgard.iplaces.config.filters')"/>


                    {{-- Custom Includes --}}
                    @if(config("asgard.iplaces.config.customIncludesAfterFilters"))
                        @foreach(config("asgard.iplaces.config.customIncludesAfterFilters") as $view)
                            @include($view)
                        @endforeach
                    @endif
                </div>

            <div class="row">
                <div class="col-12 mb-5">
                    <div class="row places-grid">
                        @if (isset($places) && !empty($places))
                            @if(count($places) >= 1)
                                @foreach($places as $place)


                                    <!-- Blog Post -->
                                    <div class="col-md-6 col-lg-4 post post{{$place->id}} mb-5">
                                        <a class="place-image d-block position-relative" href="{{$place->url}}">
                                            @if(isset($place->mediumimage)&&!empty($place->mediumimage))
                                                <img class="cover-img"
                                                     src="{{ $place->mediumimage}}"
                                                     alt="{{$place->title}}"/>
                                            @else
                                                <img class="image"
                                                     src="{{url('modules/iblog/img/post/default.jpg')}}"
                                                     alt="{{$place->title}}"/>
                                            @endif
                                            @if($place->validated)
                                            <img class="top-badge position-absolute" src="{{Theme::url('img/new/top-badge.png')}}">
                                                @endif
                                            <div class="top-stripe position-absolute w-100"></div>
                                            <div class="bottom-stripe position-absolute w-100">
                                                @for($i = 0; $i < intval($place->rating); $i++)
                                                    <i class="fa fa-star mr-1"></i>
                                                @endfor
                                            </div>
                                        </a>

                                        <h3 class="place-title text-gray-dark mt-3">{{$place->title}}</h3>

                                        <a class="btn-link text-white text-center bg-primary mt-1" href="{{$place->new_url}}">Ver más +</a>
                                    </div>
                                @endforeach
                            @else

                                <div class="col-12">
                                    <h4 class="text-center">
                                        {!! trans('iplaces::places.messages.notfound') !!}
                                    </h4>
                                </div>

                            @endif
                        @endif
                    </div>
                </div>



                {{--<aside class="col-xl-3">

                    @include('iplaces.partials.filters')

                   @include('iplaces.widgets.categories_new')

                    <div class="card card-registration border border-primary">
                        <div class="card-body text-gray-dark text-center p-0">
                            <h5 class="card-title mb-3"><strong>Se parte de San Agustín</strong></h5>

                            <p class="card-text mb-3">
                                Si eres un profesional, tienes una empresa de eventos, tienes un lugar o eres un artista
                                puedes aparecer en San Agustín, ofrecer tus servicios y productos.
                            </p>

                            <h5 class="card-subtitle text-primary mt-1 mb-3"><strong>Haz crecer tu negocio</strong></h5>

                            <a class="btn-sign-up text-white bg-primary mt-1 mx-auto" href="{{URL::to('/contacto')}}">Regístrate Gratis</a>
                        </div>
                    </div>
                </aside>--}}
            </div>
        </div>

        {{--
        @include('partials.widgets.tourism')

        @include('partials.widgets.ideas-tips')

        @include('partials.clients')

        @include('partials.subscription')

        @include('partials.map')

        @include('partials.registration')
        --}}
    </div>
@stop
