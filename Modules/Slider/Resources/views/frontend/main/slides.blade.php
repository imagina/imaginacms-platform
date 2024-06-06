@foreach($slider->slides as $index => $slide)
    @if($slide->active)
        <div class="carousel-item @if($index === 0) active @endif ">
            <img class="d-block w-100" src="{!! $slide->getImageUrl() !!}" alt="{{$slide->title}}">
            @if(!empty($slide->getLinkUrl()))
                <a href="{{$slide->getLinkUrl()}}" target="{{$slide->target}}">
                    @endif
                    @if(isset($slide->title)||isset($slide->caption) || isset($slide->custom_html))
                        <div class="carousel-caption">
                            @if(isset($slide->title))
                                @if($index==0)
                                    <h1>
                                        {{$slide->title}}
                                    </h1>
                                @else
                                    <h3>
                                        {{$slide->title}}
                                    </h3>
                                @endif
                            @endif
                            @if(isset($slide->caption))
                                <span> {{$slide->capton}}</span>
                            @endif
                            @if(isset($slide->custom_html))
                                {!! $slide->custom_html !!}
                            @endif
                        </div>
                    @endif
                    @if(!empty($slide->getLinkUrl()))
                </a>
            @endif
        </div>
    @endif
@endforeach