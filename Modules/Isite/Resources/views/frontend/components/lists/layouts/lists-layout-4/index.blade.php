<div id="{{ $id }}" class="{{ $class }} lists-layout-4">
    <div class="row">
        @if($title!=="")
            <div class="col-12">
                <div class="title-section {{$titleAlign}}">
                    @if($titleUrl)
                    <a href="{{$titleUrl}}" target="{{$titleTarget}}" style="text-decoration: none;">
                    @endif
                    <h2 class="title {{$titleColor}} {{$titleWeight}} {{$titleTransform}} mb-0" style="font-size: {{$titleSize}}px;">
                        @if($titleVineta) <i class="{{$titleVineta}} {{$titleVinetaColor}} mr-1"></i>  @endif
                        <span> {!! $title !!}</span>
                    </h2>
                    @if($titleUrl)
                    </a>
                    @endif
                </div>
                <hr class="{{$titleLineMarginY}}">
            </div>

        @endif

        <div class="list-column-1 {{$columnLeft}} {{ $orderColumnMain==1 ? 'order-1':'' }}">
            @include("isite::frontend.partials.item",["itemLayout" => $itemComponentAttributesMain['layout'], "itemComponentAttributes" => $itemComponentAttributesMain, "item" => $items[0]])
        </div>
        <div class="list-column-2 {{$columnRight}}">
            @if(!empty($preListContentView))
                <div class="mb-4">
                    @include($preListContentView)
                </div>
            @endif
            <div class="list-extra">
                @foreach ($items as $key => $item)
                    @if($key > 0)
                        <div class="list-extra-item mb-3">
                            @include("isite::frontend.partials.item",["itemLayout" => $itemComponentAttributesList['layout'],"itemComponentAttributes" => $itemComponentAttributesList])
                        </div>
                    @endif
                @endforeach

            </div>
              @if(!empty($postListContentView))
                <div class="mb-4">
                  @include($postListContentView)
                </div>
              @endif
        </div>
    </div>
</div>