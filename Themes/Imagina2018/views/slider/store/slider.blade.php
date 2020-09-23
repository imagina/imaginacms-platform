<div id="{{$slider->system_name}}" class="carousel slide carousel-store" data-ride="carousel">
    <div class="carousel-inner">
        @include('slider.store.slides', ['slider' => $slider])
    </div>
    @include('slider.store.indicators', ['slider' => $slider])
</div>