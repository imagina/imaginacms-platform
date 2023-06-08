<div class="filter-{{$type}} filter-{{$type}}-layout-{{$layout}} filter-{{$name}}">
  @if($status)
    @if($this->withTitle)
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
    @endif
    <div class="content position-relative m-3">
      @include('isite::frontend.partials.preloader')
      <div @if($isCollapsable) class="collapse multi-collapse {{$isExpanded ? 'show' : ''}}"
           id="collapse-{{$name}}" @endif>
        @if($this->withSubtitle)
          <label>{{$title}}</label>
        @endif
        <select class="form-control" name="select" wire:model="selected">
          @if($showFirstOptionSelect)
            <option value="NULL">Seleccione un(a) {{$entityTitle ?? $title}}</option>
          @endif
          @foreach($options as $item)
            <option value="{{$item->id}}">{{$item->title ?? $item->name}}</option>
          @endforeach
        </select>
      </div>
    </div>
  @endif
</div>