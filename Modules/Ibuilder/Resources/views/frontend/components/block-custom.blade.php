<section id="sectionCustom{{$id}}" class="section-custom">
    @if($position=="1" || $position=="2" || $position=="3")
        @if($position=="2" || $position=="3")
        <div class="custom-media {{$mediaClasses}} @if($position=="3") order-1 @endif">
            @if($image)
                <div class="custom-image {{$imageOnClasses}} {{$orderClasses["image"] ?? 'order-0'}}">
                    <x-media::single-image :alt="$title ?? ''"
                                           :src="$image->extraLargeThumb"
                                           :url="$buttonHref ?? null"
                                           :target="$buttonTarget"
                                           :isMedia="true"
                                           imgStyles="{{$imageStyles}}"
                                           imgClasses="image {{$imageInClasses}}"/>
                </div>
            @endif
            @if($video)
                <div class="custom-video {{$videoClasses}} {{$orderClasses["video"] ?? 'order-0'}}">
                    <div class="embed-responsive {{$videoResponsive}}">
                        <iframe class="embed-responsive-item video" src="{{$video}}"></iframe>
                    </div>
                </div>
            @endif
            @if($includeCustom)
                <div class="custom-include {{$orderClasses["include"] ?? 'order-0'}}">
                    @include($includeCustom)
                </div>
            @endif
        </div>
        @endif
        <div class="custom-contents d-flex flex-column {{$contentClasses}}">
        @if($position=="1")
            @if($image)
                <div class="custom-image {{$imageOnClasses}} {{$orderClasses["image"] ?? 'order-1'}}">
                    <x-media::single-image :alt="$title ?? ''"
                                           :src="$image->extraLargeThumb"
                                           :url="$buttonHref ?? null"
                                           :target="$buttonTarget"
                                           :isMedia="true"
                                           imgStyles="{{$imageStyles}}"
                                           imgClasses="image {{$imageInClasses}}"/>
                </div>
            @endif
            @if($video)
                <div class="custom-video {{$videoClasses}} {{$orderClasses["video"] ?? 'order-0'}}">
                    <div class="embed-responsive {{$videoResponsive}}">
                        <iframe class="embed-responsive-item video" src="{{$video}}"></iframe>
                    </div>
                </div>
            @endif
            @if($includeCustom)
                <div class="custom-include {{$orderClasses["include"] ?? 'order-7'}}">
                    @include($includeCustom)
                </div>
            @endif
        @endif
        @if($titleCustom)
            <div class="custom-title {{$orderClasses["title"] ?? 'order-2'}}">
                <h2 class="title {{$titleClasses}}" @if($titleSize) style="font-size: clamp(1rem,5vw,{{$titleSize}}); line-height: clamp(1rem,5vw,{{$titleSize}});"@endif>
                    {{$titleCustom}}
                </h2>
            </div>
        @endif
        @if($subTitleCustom)
            <div class="custom-subtitle {{$orderClasses["subtitle"] ?? 'order-3'}}">
                <p class="subtitle {{$subTitleClasses}}" @if($subTitleSize) style="font-size: clamp(1rem,5vw,{{$subTitleSize}}); line-height: clamp(1rem,5vw,{{$subTitleSize}});"@endif>
                    {{$subTitleCustom}}
                </p>
            </div>
        @endif
        @if($summaryCustom)
            <div class="custom-summary {{$orderClasses["summary"] ?? 'order-4'}}">
                <div class="summary {{$summaryClasses}}" @if($summarySize) style="font-size: clamp(1rem,5vw,{{$summarySize}}); line-height: clamp(1rem,5vw,{{$summarySize}});"@endif>
                    {!! $summaryCustom !!}
                </div>
            </div>
        @endif
        @if($descriptionCustom)
            <div class="custom-description {{$orderClasses["description"] ?? 'order-5'}}">
                <div class="description {{$descriptionClasses}}">
                    {!! $descriptionCustom !!}
                </div>
            </div>
        @endif
        @if($withButton)
            <div class="custom-button {{$buttonAlign}} {{$orderClasses["buttom"] ?? 'order-6'}}">
                <x-isite::button :style="$buttonLayout"
                                 :buttonClasses="$buttonLayout.' '.$buttonStyle.' '.$buttonClasses"
                                 :href="$buttonHref"
                                 :withIcon="$buttonIconPosition"
                                 :iconPosition="$buttonIconPosition"
                                 :iconClass="$buttonIconClass"
                                 :withLabel="$buttonLabel"
                                 :sizeLabel="$buttonSizeLabel"
                                 :color="$buttonColor"
                                 :label="$buttonLabel"
                                 :target="$buttonTarget"/>
            </div>
        @endif
    </div>
    @endif

    @if($position=="4" || $position=="5")
        <div class="custom-title d-flex flex-column">
            @if($titleCustom)
                <div class="custom-title {{$orderClasses["title"] ?? 'order-0'}}">
                    <h2 class="title {{$titleClasses}}" @if($titleSize) style="font-size: clamp(1rem,5vw,{{$titleSize}}); line-height: clamp(1rem,5vw,{{$titleSize}});"@endif>
                        {{$titleCustom}}
                    </h2>
                </div>
            @endif
            @if($subTitleCustom)
                <div class="custom-subtitle {{$orderClasses["subtitle"] ?? 'order-1'}}">
                    <p class="subtitle {{$subTitleClasses}}" @if($subTitleSize) style="font-size: clamp(1rem,5vw,{{$subTitleSize}}); line-height: clamp(1rem,5vw,{{$subTitleSize}});"@endif>
                        {{$subTitleCustom}}
                    </p>
                </div>
            @endif
        </div>
        <div class="custom-body">
            <div class="custom-media d-flex flex-column {{$mediaClasses}} @if($position=="5") order-1 @endif">
                @if($image)
                    <div class="custom-image {{$imageOnClasses}} {{$orderClasses["image"] ?? 'order-0'}}">
                        <x-media::single-image :alt="$title ?? ''"
                                               :src="$image->extraLargeThumb"
                                               :url="$buttonHref ?? null"
                                               :target="$buttonTarget"
                                               :isMedia="true"
                                               imgStyles="{{$imageStyles}}"
                                               imgClasses="image {{$imageInClasses}}"/>
                    </div>
                @endif
                @if($video)
                    <div class="custom-video {{$videoClasses}} {{$orderClasses["video"] ?? 'order-0'}}">
                        <div class="embed-responsive {{$videoResponsive}}">
                            <iframe class="embed-responsive-item video" src="{{$video}}"></iframe>
                        </div>
                    </div>
                @endif
                @if($includeCustom)
                    <div class="custom-include {{$orderClasses["include"] ?? 'order-0'}}">
                        @include($includeCustom)
                    </div>
                @endif
            </div>
            <div class="custom-contents d-flex flex-column {{$contentClasses}}">
                @if($summaryCustom)
                    <div class="custom-summary {{$orderClasses["summary"] ?? 'order-4'}}">
                        <div class="summary {{$summaryClasses}}" @if($summarySize) style="font-size: clamp(1rem,5vw,{{$summarySize}}); line-height: clamp(1rem,5vw,{{$summarySize}});"@endif>
                            {!! $summaryCustom !!}
                        </div>
                    </div>
                @endif
                @if($descriptionCustom)
                    <div class="custom-description {{$orderClasses["description"] ?? 'order-5'}}">
                        <div class="description {{$descriptionClasses}}">
                            {!! $descriptionCustom !!}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    @endif

</section>
<style>
    @if($position=="2" || $position=="3" || $position=="4" || $position=="5")
    #sectionCustom{{$id}} @if($position=="4" || $position=="5") .custom-body @endif  {
        display: grid;
        gap: {{$gridGap}};
        grid-template-columns: {{$gridColumns}};
    }
    @media (max-width: 768px) {
        #sectionCustom{{$id}} @if($position=="4" || $position=="5") .custom-body @endif   {
            grid-template-columns: repeat(1, minmax(0, 1fr));
        }
    }
    @endif
</style>