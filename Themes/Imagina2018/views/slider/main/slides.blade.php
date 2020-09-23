@foreach($slider->slides as $index => $slide)
{{--    {{dd($slide->url)}}--}}
    <div class="carousel-item @if($index === 0) active @endif h-100">
        <div class="container img-height-slider">
            <img  class="d-block  object-fit-cover position-absolute" src="{!! $slide->getImageUrl() !!}" alt="{{$slide->title??Setting::get('core::site-name')}}">
        </div>

        <div class="carousel-caption p-0 margins-text-slider">
            <div class="container margins-text-slider2">
                <div class="container h-100">
                    <div class="row h-100 align-items-center justify-content-start">
                        <div class="col-10 col-xl-10">
                            @if(!empty($slide->title))
                                <h3 class="mb-0 margins-text-slider4">{{$slide->title}}</h3>
                            @endif
                            @if(!empty($slide->caption))
                                <div class="row">
                                    <div class="container">
                                        <h2 class="mb-0 caption centered2" >{{$slide->caption}}</h2>        
                                    </div>
                                </div>


                            @endif
                            @if(!empty($slide->custom_html))
                                <div class=" text-slider margins-text-slider3">
                                    {!! $slide->custom_html !!}
                                </div>
                            @endif
                            @if(!empty($slide->uri))
                                <div class="">
                                    <a class=" btn-slider btn btn-light rounded  text-primary"  href="{{$slide->uri}}">{{$slide->url}}</a>
                                </div>

                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endforeach

