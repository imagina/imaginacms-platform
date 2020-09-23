@if(count($slider->slides) > 1)
    <div class="carousel-controls position-absolute">
        <div class="container position-relative h-100">
            <a class="carousel-control carousel-control-prev ml-2" href="#{{$slider->system_name}}" role="button" data-slide="prev">
                <i class="fa fa-arrow-left" aria-hidden="true"></i>
            </a>
            <a class="carousel-control carousel-control-next mr-2" href="#{{$slider->system_name}}" role="button" data-slide="next">
                <i class="fa fa-arrow-right" aria-hidden="true"></i>
            </a>

            {{--  <img class="guaranteed d-none d-lg-block" src="{{Theme::url('img/new/guaranteed.png')}}"> --}}
        </div>
    </div>
@endif