
@foreach($slider->slides as $index => $slide)

    <div class="item animated fadeIn">
        @if(!empty($slide->external_image_url))
            @if(strpos($slide->external_image_url,"youtube.com"))
                <iframe width="100%" height="{{$item>4?"350":"250"}}" src="{{ $slide->external_image_url }}"
                        frameborder="0" allowfullscreen></iframe>
            @else
                <x-media::single-image :alt="$slide->title ?? setting::get('core::site-name')"
                                      :title="$slide->title ?? setting::get('core::site-name')"
                                      :url="$slide->uri ?? null" :isMedia="true"
                                      imgClasses="img-fluid w-100"
                                      :mediaFiles="$slide->mediaFiles()" zone="slideimage"/>
            @endif
        @else

            @if(!empty($slide->getLinkUrl()))
                <a href="{{ $slide->getLinkUrl() }}" target="{{ $slide->target }}">
            @endif
    
                    <x-media::single-image :alt="$slide->title ?? setting::get('core::site-name')"
                                          :title="$slide->title ?? setting::get('core::site-name')"
                                          :url="$slide->uri ?? null" :isMedia="true"
                                          imgClasses="img-fluid w-100"
                                          :mediaFiles="$slide->mediaFiles()" zone="slideimage"/>

                @if(isset($slide->title) && !empty($slide->title))
                    <h1>{{$slide->title}}</h1>
                @endif

            @if(!empty($slide->getLinkUrl()))
                </a>
            @endif

        @endif

    </div>
@endforeach
