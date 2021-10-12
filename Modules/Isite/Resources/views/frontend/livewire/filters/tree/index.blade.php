<div class="filter-tree filter-{{$name}} filter-tree-style-{{$layout}} mb-4">
@if($items && count($items)>0)
    
    <div class="title">
      <a class="item" data-toggle="collapse" href="#collapseCategories" role="button" aria-expanded="{{$isExpanded ? 'true' : 'false'}}" aria-controls="collapseCategories" class="{{$isExpanded ? '' : 'collapsed'}}">
        
        <h5 class="p-3 border-top border-bottom">
          {{ trans($title) }}
          <i class="fa fa angle float-right" aria-hidden="true"></i>
        </h5>
      
      </a>
    </div>
    
    <div class="collapse {{$isExpanded ? 'show' : ''}}" id="collapseCategories">
      <div class="row">
        <div class="col-12">
          <div class="list-categories">
            <ul class="list-group list-group-flush">
            
            @foreach($items->where("parent_id",0) as $item)
                @include('isite::frontend.livewire.filters.tree.single-item',["level" => 0,"item" => $item,"itemId" => $item->id])
              @endforeach
            
            
            </ul>
          </div>
        </div>
      </div>
    </div>
  
@endif
</div>

@section("scripts")
  @parent
  <script>
    
      function emit_{{$name}}(itemId,itemUrl){
        var configEmit =  {!! $emitTo ? 'true' : 'false' !!};
        console.warn("adsadasdasd12312321")
        if(configEmit){
          console.warn("adsadasdasd")
          window.livewire.emit('updateItemSelected',itemId)
        }else{
          window.location.href = itemUrl
        }
      }
   
    
  </script>
@endsection