@foreach($slider->slides as $index => $slide)
    @if($slide->active)
        <div class="carousel-item @if($index === 0) active @endif ">
          <x-media::single-image :alt="$slide->title ?? setting::get('core::site-name')"
                                :title="$slide->title ?? setting::get('core::site-name')"
                                :url="$slide->uri ?? null" :isMedia="true"
                                imgClasses="d-block w-100"
                                :mediaFiles="$slide->mediaFiles()" zone="slideimage"/>
          
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