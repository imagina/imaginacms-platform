@foreach($slider->slides as $index => $slide)
    <div class="carousel-item @if($index === 0) active @endif">
        <div  class="cover-img-16 mb-5" style="padding-bottom: 30.25%;">
            <img src="{!! $slide->getImageUrl() !!}" class="img-fluid" alt="{{$slide->title??Setting::get('core::site-name')}}">
        </div>
    </div>
@endforeach

