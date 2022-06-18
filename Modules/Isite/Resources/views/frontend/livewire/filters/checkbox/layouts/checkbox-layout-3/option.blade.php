<div class="option option-{{$option->id}} mb-4 {{$childrenClasses}}">

  <div class="title">
    <a class="item" data-toggle="collapse" href="#collapseOption-{{$option->id}}" role="button" aria-expanded="{{$isExpanded ? 'true' : 'false'}}"
       aria-controls="collapseOption-{{$option->id}}" class="{{$isExpanded ? '' : 'collapsed'}}">

      <h5 class="position-relative p-3 border-top border-bottom">
        {{$option->title}}
      </h5>

    </a>
  </div>

  <div class="content position-relative">
    <div class="collapse {{$isExpanded ? 'show' : ''}}" id="collapseOption-{{$option->id}}" wire:ignore.self>
      <div class="row">
        <div class="col-12">

          <div class="list-option-values">
            @php($children = $option->children)

            @if($children->isNotEmpty())
              @foreach($children as $option)

                <div class="custom-checkbox mr-2 mb-2 {{$tagBoxs ? 'tagBoxs' : ''}}">

                  <input
                    type="checkbox"
                    name="{{$name}}{{$option->id}}"
                    id="{{$name}}{{$option->id}}"
                    value="{{$option->id}}"
                    wire:model="selectedOptions">

                  <label for="{{$name}}{{$option->id}}">
                    <span>{{$option->name ?? $option->title}}</span>
                  </label>

                </div>

              @endforeach
            @endif

          </div>

        </div>
      </div>
    </div>

  </div>
  <style>
      .option .item h5:after {
          font-family: FontAwesome;
          content:"\f107";
          color: grey;
          float: right;
      }
      .option .item.collapsed h5:after {
          content:"\f105";
      }
  </style>
</div>