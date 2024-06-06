<div id="{{ $id }}" class="d-block py-2">
  
  <!--- LOGIN -->
    @if($user)
    
    
    <nav class="navbar navbar-expand-lg navbar-light bg-light d-block">
    
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
              aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <a class="d-inline  d-sm-none navbar-brand" href="#">{{trans("iprofile::frontend.button.my_account")}}</a>
      
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto flex-column w-100">
          <li class="nav-item">
            <a class="dropdown-item"  href="{{\URL::route(\LaravelLocalization::getCurrentLocale() . '.iprofile.account.index')}}">
              <i class="fa fa-user mr-2"></i> {{trans('iprofile::frontend.title.profile')}}
            </a>
          </li>
          @foreach($moduleLinks as $link)
            <li class="nav-item">
              <a class="dropdown-item"  href="{{ route($link['routeName']) }}">
                @if($link['icon'])<i class="{{ $link['icon'] }}"></i>@endif {{ trans($link['title']) }}
              </a>
            </li>
          @endforeach
          <li class="nav-item">
            <a class="dropdown-item" href="{{url('/account/logout')}}" data-placement="bottom"
               title="Sign Out">
              <i class="fa fa-sign-out mr-1"></i>
              <span>{{trans('iprofile::frontend.button.sign_out')}}</span>
            </a>
          </li>
        
        </ul>
      
      </div>
    </nav>
    @endif


    @section('scripts')
        <script type="text/javascript">
          $("#accMenuDrop").hover(function(){
            $(this).addClass("show");
            $('#drop-menu').addClass("show");
          }, function(){
            $(this).removeClass("show");
            $('#drop-menu').removeClass("show");
          });
        </script>
        @parent
    @endsection

</div>
