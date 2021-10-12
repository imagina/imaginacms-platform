@if(!empty($url) || $dataFancybox)
    <a href="{{ $dataFancybox ? $src : $url }}" title="{{$title}}" class="{{$defaultLinkClasses}} {{$linkClasses}}"
            {{$dataFancybox ? "data-fancybox=$dataFancybox" : ''}}
            {{$dataCaption ? "data-caption=$dataCaption" : ''}} target="{{$target}}" rel="{{!empty($linkRel) ? $linkRel : ""}}">
    @endif
    <!--Use data-srcset, data-src and specify lazyload class for images -->
        <picture>
            @if(!empty($smallSrc))
                <source data-srcset='{{$smallSrc}} 300w' type="image/webp" media="(max-width: 300px)">
            @endif
            @if(!empty($mediumSrc))
                <source data-srcset='{{$mediumSrc}} 600w' type="image/webp" media="(max-width: 600px)">
            @endif
            @if(!empty($largeSrc))
                <source data-srcset='{{$largeSrc}} 900w' type="image/webp" media="(max-width: 900px)">
            @endif
            @if(!empty($extraLargeSrc))
                <source data-srcset='{{$extraLargeSrc}} 1920w' type="image/webp" media="(min-width: 900px)">
            @endif
            @if(!empty($fallback))
                <source data-srcset='{{$fallback}}' type="image/{{$fallbackExtension}}">
            @endif

            <img data-src="{{$fallback}}"
                 data-srcset="{{!empty($smallSrc) ? $smallSrc." 300w" : ""}}
                 {{!empty($mediumSrc) ? ", ".$mediumSrc." 600w" : ""}}
                 {{!empty($largeSrc) ? ", ".$largeSrc." 900w" : ""}}
                 {{!empty($extraLargeSrc) ? ", ".$extraLargeSrc." 1920w" : ""}}"
                 class="lazyload {{$imgClasses}}"
                 alt="{{$alt}}"
                 style="{{$imgStyles}}"
                 data-sizes="auto"
                 data-parent-fit="contain"
                 data-parent-container=".image-link"
                 
            />
        </picture>

        @if(!empty($url)|| $dataFancybox)
    </a>
@endif

