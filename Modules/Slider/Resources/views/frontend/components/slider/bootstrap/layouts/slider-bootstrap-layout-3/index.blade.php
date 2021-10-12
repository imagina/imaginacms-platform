<div class="bootstrap-slider-layout-3">

    <div id="{{ $slider->system_name }}" class="carousel slide "
         data-ride="carousel" data-pause="{{ $pause }}">
        @if($dots)
            <ol class="carousel-indicators carousel-indicators-position-{{ $dotsPosition }} carousel-indicators-style-{{ $dotsStyle }}">
                @foreach($slider->slides as $index => $slide)
                    <li data-target="#{{ $slider->system_name }}" data-slide-to="{{ $index }}"
                        @if($index === 0) class="active" @endif></li>
                @endforeach
            </ol>
        @endif
        @php $check = 0; @endphp
        <div class="carousel-inner">

            <img class="img-fondo d-block  w-100" src="{{ $backgroundImg }}" alt="background img">

            @foreach($slider->slides as $index => $slide)

                @if($slide->active)
                    <div class="carousel-item @if($index === 0) active @endif">

                        <div class="carousel-caption text-left p-0 ">
                            <div class="container">
                                <div class="row align-items-center justify-content-center pt-5">
                                    <div class="col-md-11 col-lg-6  pb-5">

                                        @if(!empty($slide->title) || !empty($slide->caption) || !empty($slide->custom_html))

                                                @if(!empty($slide->title))
                                                    <h1 class="title h1">{{$slide->title}}</h1>
                                                @endif

                                                @if(!empty($slide->custom_html))
                                                    <div class="custom-html">
                                                        {!! $slide->custom_html !!}
                                                    </div>
                                                @endif

                                                <div class="d-block">
                                                    <a class="btn"
                                                       href="{{ $slide->url ?? $slide->uri }}">{{ $slide->caption ?? trans('isite::common.menu.viewMore') }}</a>
                                                </div>

                                        @endif


                                    </div>
                                    <div class="col-lg-6 pb-5 d-none d-lg-block">
                                        <div class="image-circle mx-auto">
                                            <x-media::single-image
                                                    :alt="$slide->title ?? Setting::get('core::site-name')"
                                                    :title="$slide->title ?? Setting::get('core::site-name')"
                                                    :url="$slide->uri ?? null" :isMedia="true"
                                                    :mediaFiles="$slide->mediaFiles()" zone="slideimage"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                @endif
                @php $check++; @endphp

            @endforeach
        </div>
        @if($arrows)
            @if(count($slider->slides) > 1)
                <a class="carousel-control-prev" href="#{{$slider->system_name}}" role="button" data-slide="prev">
                    <i class="fa fa-angle-left"></i>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#{{$slider->system_name}}" role="button" data-slide="next">
                    <i class="fa fa-angle-right"></i>
                    <span class="sr-only">Next</span>
                </a>
            @endif
        @endif
    </div>
</div>