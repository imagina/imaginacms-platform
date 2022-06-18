<div class="filter-{{$type}} filter-{{$type}}-layout-{{$layout}} filter-{{$name}}">
  
  
  @if($status)
    <div class="title">
      <a class="item mb-3" @if($isCollapsable) data-toggle="collapse" href="#collapse-{{$name}}" role="button"
         aria-expanded="{{$isExpanded ? 'true' : 'false'}}" aria-controls="collapse-{{$name}}"
         class="{{$isExpanded ? '' : 'collapsed'}}" @endif>
        <h5 class="p-3 border-top border-bottom">
          <i class="fa angle float-right" aria-hidden="true"></i>
          {{$title}}
        </h5>
      
      </a>
    </div>
    
    <div @if($isCollapsable) class="collapse multi-collapse {{$isExpanded ? 'show' : ''}}"
         id="collapse-{{$name}}" @endif>
      <label>{{$title}}</label>
      <input type="text" class="form-control" id="{{$name}}" aria-describedby="{{$name}}"
             placeholder="{{$placeholder}}" wire:model.debounce.500ms="value">
    </div>
  @endif
</div>