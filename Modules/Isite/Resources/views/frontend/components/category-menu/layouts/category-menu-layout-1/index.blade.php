<div id="{{ $id }}">
    <button class="navbar-toggler d-block d-lg-none my-2 " type="button" data-toggle="modal" data-target="#{{ $id }}menuModal" aria-label="Toggle navigation">
        {!! $title !!}
    </button>
    <div class="col-auto d-none d-lg-block">
        <nav id="categoryMegaMenu" class="navbar navbar-expand-lg navbar-category p-0">
            <div id="{{ $id }}navbarCollapse" class="collapse navbar-collapse">
                <ul id="{{ $id }}navbarUl" class="navbar-nav">
                    <li id="{{ $id }}liNavItem" class="nav-item dropdown">
                        <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-bars mr-2"></i> {!! $title !!}
                        </a>
                        <ul id="{{ $id }}ulNavItem" class="{{$params["type"] ?? "dropdown-menu"}}">
                            @foreach($items as $item)
                                @php($firstChildrenLevel = count($item->children) ? $item->children  : null)
                                <li class="nav-item {{$firstChildrenLevel ? 'dropdown' : ''}}">
                                    <a href="{{$item->url}}" onclick="redirectMainCategory('{{$item->url}}')"
                                       class="nav-link" data-toggle="{{$firstChildrenLevel ? 'dropdown' : ''}}">
                                        @php($mediaFiles = $item->mediaFiles())

                                        @if(isset($mediaFiles->iconimage->path) && !strpos($mediaFiles->iconimage->path,"default.jpg"))
                                            <img class="filter" src="{{$mediaFiles->iconimage->path}}">
                                        @endif
                                        {{ $item->title ?? $item->name }}
                                    </a>
                                    @if($firstChildrenLevel)
                                        <div class="dropdown-menu">
                                            <h3><a href="{{$item->url}}">{{ $item->title ?? $item->name }}</a></h3>
                                            @if($firstChildrenLevel)
                                                <ul class="frame-dropdown {{ count($firstChildrenLevel) > 1 ? "frame-dropdown2": ""}}">
                                                    @foreach($firstChildrenLevel as $firstChildLevel)
                                                      @if($firstChildLevel->status)
                                                        <li class="nav-item">
                                                            <a class="nav-link" href="{{$firstChildLevel->url}}">{{ $firstChildLevel->title ?? $firstChildLevel->name }}</a>
                                                            @php($secondChildrenLevel = $firstChildLevel->children ?? null)
                                                            @if($secondChildrenLevel)
                                                                <div class="dropdown-submenu">
                                                                    @foreach($secondChildrenLevel as $secondChildLevel)
                                                                    @if($secondChildLevel->status)
                                                                        <a href="{{$secondChildLevel->url}}">{{ $secondChildLevel->title ?? $secondChildLevel->name }}</a>
                                                                    @endif
                                                                    @endforeach
                                                                </div>
                                                            @endif
                                                        </li>
                                                    @endif
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </div>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
    <div class="modal modal-menu fade" id="{{ $id }}menuModal" tabindex="-1" role="dialog"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header rounded-0">
                    <x-isite::logo name="logo1" central="central" imgClasses="mx-auto my-2"/>
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

        //Redirect to main category if is desktop
        window.redirectMainCategory = function (url = false) {
          var width = (window.innerWidth > 0) ? window.innerWidth : screen.width;
          if (width >= 992) window.location.href = url
        }

        function divtomodal() {

          var width = (window.innerWidth > 0) ? window.innerWidth : screen.width;
          if (width <= 992) {
            console.log('xs');
            $('#{{ $id }}ulNavItem').addClass("navbar-nav");
            $('#{{ $id }}ulNavItem').removeClass("dropdown-menu");
            $('#{{ $id }}modalBody').append($("#{{ $id }}ulNavItem"));
          } else {
            console.log('not-xs');
            $('#{{ $id }}ulNavItem').removeClass("navbar-nav");
            $('#{{ $id }}ulNavItem').addClass("dropdown-menu");
            $('#{{ $id }}liNavItem').append($("#{{ $id }}ulNavItem"));
          }

        }

        $(window).resize(divtomodal);

        var width = (window.innerWidth > 0) ? window.innerWidth : screen.width;
        if(width<=992)
          divtomodal()


      });
    </script>

@stop
