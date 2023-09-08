<div id="{{ $id }}" class="{{ $class }} lists-layout-5">
    @if($title!=="" || $subtitle!=="")
    <div class="row">
            <div class="col-12">
                <div class="title-section {{$textAlign}} @if($textPosition==3) d-flex flex-column @endif ">
                    @if($title!=="")
                        @if($titleUrl)
                            <a href="{{$titleUrl}}" target="{{$titleTarget}}" class="text-decoration-none">
                                @endif
                                <h2 class="title {{$titleClasses}} {{ $textPosition==3 ? 'order-1':'' }} {{$titleColor}} {{$titleWeight}} {{$titleTransform}}">
                                    @if($titleVineta) <i class="{{$titleVineta}} {{$titleVinetaColor}} mr-1"></i>  @endif
                                    <span> {!! $title !!}</span>
                                </h2>
                                @if($titleUrl)
                            </a>
                        @endif
                    @endif
                    @if($subtitle!=="" && $textPosition!=1)
                        <h3 class="subtitle {{$subtitleClasses}} {{$subtitleColor}} {{$subtitleWeight}} {{$subtitleTransform}}">
                            {!! $subtitle !!}
                        </h3>
                    @endif
                </div>
                <hr class="{{$titleLineMarginY}}">
            </div>
        </div>
    @endif
    @if(!empty($itemComponentAttributes["itemDelay"]))
        @php($delay = $itemComponentAttributes['itemDelay'])
        @php($cont=0)
    @endif
    <div class="row">
    @foreach ($items as $key => $item)
        @if(!empty($itemComponentAttributes["itemDelay"]))
            @php($itemComponentAttributes["itemDelay"]=$delay+$cont)
            @if(!empty($itemComponentAttributes["itemDelayIn"]))
            @php($cont=$cont+intval($itemComponentAttributes['itemDelayIn']))
            @endif
        @endif
        <div class="{{$columnLayout[$key%count($columnLayout)]}}">
            @include("isite::frontend.partials.item",["itemLayout" => $itemComponentAttributes['layout'],"itemComponentAttributes" => $itemComponentAttributes])
        </div>
    @endforeach
    </div>
</div>
<style>
    #{{$id}} .title-section .title {
        font-size: {{$titleSize}}px;
        letter-spacing: {{$titleLetterSpacing}}px;
    }
    #{{$id}} .title-section .subtitle {
         font-size: {{$subtitleSize}}px;
         letter-spacing: {{$subtitleLetterSpacing}}px;
     }
    @if($withLineTitle==1)
    #{{$id}} .title-section .title:after {
        content: '';
        display: block;
        @foreach($lineTitleConfig as $key => $line)
        {{$key}}: {{$line}};
        @endforeach
    }
    @endif
    @if($withLineTitle==2)
    #{{$id}} .title-section .subtitle:after {
         content: '';
         display: block;
         @foreach($lineTitleConfig as $key => $line)
        {{$key}}: {{$line}};
         @endforeach
    }
    @endif
</style>