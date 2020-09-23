{{--{{dd($slider->system_name)}}--}}
<div id="{{$slider->system_name}}" class="carousel slide" data-ride="carousel">
    <div class="carousel-inner img-height-slider2">
        @include('slider.main.slides', ['slider' => $slider])
    </div>
    @include('slider.main.indicators', ['slider' => $slider])
</div>
