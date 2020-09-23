@foreach($slider->slides as $index => $slide)
    <div class="item">
        @if(!empty($slide->getLinkUrl()))
            <a href="{{$slide->getLinkUrl()}}" target="{{$slide->target}}">
                <img  src="{{$slide->getImageUrl()}}" class="img-fluid" alt="{{$slide->title}}">
            </a>
        @else
            <img src="{{$slide->getImageUrl()}}" class="img-fluid" alt="{{$slide->title}}">
        @endif
    </div>
@endforeach