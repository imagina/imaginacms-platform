<nav id="{{$id}}">
  @if($menuBefore)
    @menu($menuBefore,'imagina-navbar')
  @endif

  <ul id="{{ $id }}navbarUl"  class="navbar-nav">
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
    @menu($menuAfter,'imagina-navbar')
  @endif
</nav>

