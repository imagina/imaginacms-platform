
@foreach($slider->slides as $index => $slide)

    <div class="item animated fadeIn">
        <div class="row ">
                <div class=" col-12 d-flex justify-content-center text-center">
                    <div class="content-title">
                        <img class="" src="{!! $slide->getImageUrl() !!}" alt="{{$slide->title}}">
                    </div> 
                </div>

        </div>
    </div>

@endforeach
