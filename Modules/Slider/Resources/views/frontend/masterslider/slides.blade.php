@foreach($slider->slides as $index => $slide)

    <div class="ms-slide @if($index === 0) active @endif ">
        @if(!empty($slide->getLinkUrl()))
            <a href="{{ $slide->getLinkUrl() }}" target="{{ $slide->target }}"> </a>
        @endif
    
            <x-media::single-image :alt="$slide->title ?? setting::get('core::site-name')"
                                  :title="$slide->title ?? setting::get('core::site-name')"
                                  :url="$slide->uri ?? null" :isMedia="true"
                                  :mediaFiles="$slide->mediaFiles()" zone="slideimage"/>

        <div class="ms-info">
            <h3>{{ $slide->title }}</h3>
            <h4>{{ $slide->caption }}</h4>
            <p></p>
        </div>


    </div>


@endforeach