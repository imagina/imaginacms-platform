<div class="item">
    <div class="card card-plan border-0 bg-transparent mb-5 pb-3">
        <div class="card-header text-center rounded">
            <h2 class="title mt-4"> {{$item->name}}</h2>
            <h3 class="price">
                ${{formatMoney($item->product ? $item->product->discount->price ?? $item->product->price : '0',true)}}
                <br>
                {!! !empty($item->product) ? isset($item->product->discount->price) ? "<del>$".formatMoney($item->product->price)."</del>" : "" : "" !!}
            </h3>
        </div>
        <div class="card-frame rounded-bottom">
            <div class="card-body bg-white p-4">
                {!! $item->description !!}
            </div>
            <div class="card-footer bg-white border-0 rounded-bottom text-center py-0">
                @if(isset($item->options->url) || !empty($item->product))
                <a href="{{ $item->options->url ?? route('plans.buy',['planId' => $item->id]) }}"
                   class="btn btn-primary rounded-pill">{{ trans('iplan::plans.button.buy') }}</a>
                @endif
            </div>
        </div>
    </div>
</div>
