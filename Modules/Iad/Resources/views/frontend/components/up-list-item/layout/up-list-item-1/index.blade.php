<div class="custom-control custom-control-plan custom-radio mb-4 cursor-pointer">
  <input type="radio" id="upPlanRadio{{$item->id}}" name="upId" class="custom-control-input"
         wire:model="upId" value="{{$item->id}}" required/>
  <label class="custom-control-label w-100" for="upPlanRadio{{$item->id}}">
    <div class="card-plan">
      <div class="card-plan-body">
        
        
        <h4 class="title">{{$item->title}}</h4>
        <hr>
        @if(!empty($item->description))
          <div class="custom-html">
            {!! $item->description !!}
          </div>
        @endif
        
        <h5 class="d-inline-block"><strong>{{$item->days_limit}}</strong></h5> Días <br>
        <h5 class="d-inline-block"><strong>{{$item->ups_daily}}</strong></h5> Subidas/Días
        <hr>
        @if(isset($item->product->price))
          <div class="price font-weight-bold">
            ${{formatMoney($item->product->discount->price ?? $item->product->price)}}
            <br>
            {!! isset($item->product->discount->price) ? "<del>$".formatMoney($item->product->price)."</del>" : "" !!}
          </div>
        @endif
      
      </div>
    </div>
  </label>
</div>