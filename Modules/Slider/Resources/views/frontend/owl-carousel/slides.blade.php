
@foreach($slider->slides as $index => $slide)

    <div class="item animated fadeIn">
        @if(!empty($slide->external_image_url))
            @if(strpos($slide->external_image_url,"youtube.com"))
                <iframe width="100%" height="{{$item>4?"350":"250"}}" src="{{ $slide->external_image_url }}"
                        frameborder="0" allowfullscreen></iframe>
            @else
                <img class="img-fluid w-100" src="{!! $slide->external_image_url !!}" alt="{{ $slide->title }}">
            @endif
        @else

            @if(!empty($slide->getLinkUrl()))
                <a href="{{ $slide->getLinkUrl() }}" target="{{ $slide->target }}">
            @endif

                <img class="img-fluid w-100" src="{!! $slide->getImageUrl() !!}" alt="{{ $slide->title }}">

                @if(isset($slide->title) && !empty($slide->title))
                    <h1>{{$slide->title}}</h1>
                @endif

            @if(!empty($slide->getLinkUrl()))
                </a>
            @endif

        @endif

    </div>
@endforeach
