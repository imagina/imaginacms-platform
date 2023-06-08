<div id="{{ $slider->system_name }}-bootstrap-slider-layout-3" class="bootstrap-slider-layout-3">

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
<style>
#{{ $slider->system_name }}-bootstrap-slider-layout-3 .carousel .icon {
    top: 20px;
    left: 20px;
    z-index: 9;
}
#{{ $slider->system_name }}-bootstrap-slider-layout-3 .carousel .title {
    font-size: 60px;
    font-weight: bold;
    color: #fff;
}
#{{ $slider->system_name }}-bootstrap-slider-layout-3 .carousel .title b,
#{{ $slider->system_name }}-bootstrap-slider-layout-3 .carousel .title strong {
    font-weight: bold;
}
#{{ $slider->system_name }}-bootstrap-slider-layout-3 .carousel .custom-html {
    margin-bottom: 15px;
    color: #fff;
}
#{{ $slider->system_name }}-bootstrap-slider-layout-3 .carousel .custom-html p,
#{{ $slider->system_name }}-bootstrap-slider-layout-3 .carousel .custom-html h1,
#{{ $slider->system_name }}-bootstrap-slider-layout-3 .carousel .custom-html h2,
#{{ $slider->system_name }}-bootstrap-slider-layout-3 .carousel .custom-html h3,
#{{ $slider->system_name }}-bootstrap-slider-layout-3 .carousel .custom-html h4,
#{{ $slider->system_name }}-bootstrap-slider-layout-3 .carousel .custom-html h5,
#{{ $slider->system_name }}-bootstrap-slider-layout-3 .carousel .custom-html h6 {
    font-size: 23px;
    margin-bottom: 0;
}
#{{ $slider->system_name }}-bootstrap-slider-layout-3 .carousel .btn {
    font-size: 20px;
    padding: 7px 30px;
    border-radius: 50rem !important;
    background-color: #53A318;
    border-color: #53A318;
    color: #fff;
    font-weight: 600;
}
#{{ $slider->system_name }}-bootstrap-slider-layout-3 .carousel .carousel-control-prev,
#{{ $slider->system_name }}-bootstrap-slider-layout-3 .carousel .carousel-control-next {
    z-index: 99;
    top: auto;
    bottom: 10px;
    width: auto;
    opacity: 1;
}
#{{ $slider->system_name }}-bootstrap-slider-layout-3 .carousel .carousel-control-prev i,
#{{ $slider->system_name }}-bootstrap-slider-layout-3 .carousel .carousel-control-next i {
    font-size: 25px;
    color: #fff;
}
#{{ $slider->system_name }}-bootstrap-slider-layout-3 .carousel .carousel-control-prev {
    left: 48%;
}
#{{ $slider->system_name }}-bootstrap-slider-layout-3 .carousel .carousel-control-next {
    right: 48%;
}
#{{ $slider->system_name }}-bootstrap-slider-layout-3 .carousel .carousel-item .carousel-caption {
    right: 0;
    bottom: 2%;
    left: 0;
}
#{{ $slider->system_name }}-bootstrap-slider-layout-3 .carousel .carousel-item .carousel-caption .image-circle {
    width: 400px;
    height: 400px;
    border-radius: 50%;
    background-color: var(--primary);
    background: linear-gradient(to right, #962b33 1%, #d32e34 100%);
}
#{{ $slider->system_name }}-bootstrap-slider-layout-3 .carousel .carousel-item .carousel-caption .image-circle img {
    width: 380px;
    height: 380px;
    margin-left: 10px;
    border-radius: 50%;
    margin-top: 5px;
    -o-object-fit: cover;
    object-fit: cover;
}
#{{ $slider->system_name }}-bootstrap-slider-layout-3 .carousel .img-fondo {
    height: 550px;
    -o-object-fit: cover;
    object-fit: cover;
}
@media (max-width: 991.98px) {
    #{{ $slider->system_name }}-bootstrap-slider-layout-3 .carousel .img-fondo {
        height: 400px;
    }
}
@media (max-width: 767.98px) {
    #{{ $slider->system_name }}-bootstrap-slider-layout-3 .carousel .carousel-control {
        display: none;
    }
    #{{ $slider->system_name }}-bootstrap-slider-layout-3 .carousel .title {
        font-size: 30px;
    }
    #{{ $slider->system_name }}-bootstrap-slider-layout-3 .carousel .custom-html p,
    #{{ $slider->system_name }}-bootstrap-slider-layout-3 .carousel .custom-html h1,
    #{{ $slider->system_name }}-bootstrap-slider-layout-3 .carousel .custom-html h2,
    #{{ $slider->system_name }}-bootstrap-slider-layout-3 .carousel .custom-html h3,
    #{{ $slider->system_name }}-bootstrap-slider-layout-3 .carousel .custom-html h4,
    #{{ $slider->system_name }}-bootstrap-slider-layout-3 .carousel .custom-html h5,
    #{{ $slider->system_name }}-bootstrap-slider-layout-3 .carousel .custom-html h6 {
        font-size: 16px;
    }
    #{{ $slider->system_name }}-bootstrap-slider-layout-3 .carousel .carousel-item .carousel-caption {
        right: 2%;
        left: 2%;
    }
}
</style>