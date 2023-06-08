<div id="{{ $id }}">
  
  <div class="col-auto d-block {{$collapsed ? "" : "d-lg-none"}} px-1 px-sm-3">
    <ul class="nav justify-content-center">
      <li class="nav-item">
        <a class="nav-link link-movil cursor-pointer" data-toggle="modal" data-target="#{{ $id }}menuModal">
          <i class="fa fa-bars"></i> {{$title}}
        </a>
      </li>
    </ul>
  </div>
  
  <div id="{{ $id }}contentToMove">
    <nav id="{{$id}}nav" class="navbar d-none d-lg-block navbar-expand-lg navbar-category-2 p-0 {{$collapsed ? "d-none" : ""}}">
      @if($menuBefore)
        @menu($menuBefore,'imagina-navbar',['organization_id' => tenant()->id ?? null])
      @endif
      
      <ul id="{{ $id }}navbarUl" class="navbar-nav">
        @if($withHome)
          <li class="nav-item">
            <a href="{{url('/')}}" class="nav-link">
              @if($homeIcon)
                <i class="{{$homeIcon}}" aria-hidden=Q"true"></i>
              @else
                {{ trans('isite::common.menu.home') }}
              @endif
            </a>
          </li>
        @endif
        @foreach($items as $item)
          @php($firstChildrenLevel = $item->children)
          <li class="nav-item {{$firstChildrenLevel->isNotEmpty() ? 'dropdown' : ''}}">
            <a href="{{$item->url}}" class="nav-link {{$firstChildrenLevel->isNotEmpty() ? ' dropdown-toggle' : ''}}" data-toggle="{{$firstChildrenLevel->isNotEmpty() ? 'dropdown' : ''}}">
              @php($mediaFiles = $item->mediaFiles())
              
              @if(isset($mediaFiles->iconimage->path) && !strpos($mediaFiles->iconimage->path,"default.jpg"))
                <img class="filter" src="{{$mediaFiles->iconimage->path}}">
              @endif
              {{ $item->title ?? $item->name }}
            </a>
            @if($firstChildrenLevel->isNotEmpty())
              <ul class="dropdown-menu">
                @foreach($firstChildrenLevel as $firstChildLevel)
                  @php($secondChildrenLevel = $firstChildLevel->children)
                  <li class="nav-item {{$secondChildrenLevel->isNotEmpty() ? 'dropdown' : ''}}">
                    <a class="nav-link" data-toggle="{{$secondChildrenLevel->isNotEmpty() ? 'dropdown' : ''}}" href="{{$firstChildLevel->url}}">{{ $firstChildLevel->title ?? $firstChildLevel->name }}</a>
                    @if($secondChildrenLevel->isNotEmpty())
                      
                      <ul class="dropdown-menu">
                        @foreach($secondChildrenLevel as $secondChildLevel)
                          <li class="nav-item">
                            <a class="nav-link" href="{{$secondChildLevel->url}}">{{ $secondChildLevel->title ?? $secondChildLevel->name }}</a>
                          </li>
                        @endforeach
                      </ul>
                    
                    @endif
                  </li>
                @endforeach
              </ul>
            
            @endif
          </li>
        @endforeach
      </ul>
      
      @if($menuAfter)
        @menu($menuAfter,'imagina-navbar',['organization_id' => tenant()->id ?? null])
      @endif
    </nav>
  
  </div>
  
  <div class="modal modal-menu fade" id="{{ $id }}menuModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header rounded-0">
          <x-isite::logo name="logo1" imgClasses="mx-auto my-2"/>
          <button  type="button" class="close my-0" data-dismiss="modal" aria-label="Close">
            <i class="fa fa-times-circle text-white"></i>
          </button>
        </div>
        <div class="modal-body">
          
          <nav class="navbar navbar-movil p-0">
            
            <div class="collapse navbar-collapse show " id="{{ $id }}modalBody">
            </div>
          </nav>
        </div>
      </div>
    </div>
  </div>
</div>
@include('isite::frontend.components.category-menu.partials.style')
@section('scripts-owl')
  @parent
  <script>
    
    $(document).ready(function () {

      
      window.isite_menu_divtomodal = function () {
        var collapsed = {!! $collapsed ? 'true' : 'false' !!}
        var width = (window.innerWidth > 0) ? window.innerWidth : screen.width;
        if (width <= 992 || collapsed) {
          
          $('#{{ $id }}modalBody').append($("#{{ $id }}nav"));
          
          
          $('#{{$id}}nav').removeClass("d-none");
          
        } else {
          
          $('#{{ $id }}contentToMove').append($("#{{ $id }}nav"));
        }
      }
      
      $(window).resize(function(){window.isite_menu_divtomodal()});
      
      var width = (window.innerWidth > 0) ? window.innerWidth : screen.width;
      var collapsed = {!! $collapsed ? 'true' : 'false' !!}
      if(width<=992 || collapsed){
        window.isite_menu_divtomodal()
      }
      
    });
  </script>

@stop
