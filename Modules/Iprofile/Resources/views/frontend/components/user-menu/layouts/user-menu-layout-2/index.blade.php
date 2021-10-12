<div id="{{ $id }}" class="d-block py-2">
  
  <!--- LOGIN -->
    @if($user)
      
        <ul class="list-sidebar">
          <li class="nav-item">
            <a  href="{{\URL::route(\LaravelLocalization::getCurrentLocale() . '.iprofile.account.index')}}">
              <i class="fa fa-user mr-2"></i> <span class="nav-label">{{trans('iprofile::frontend.title.profile')}} </span>
            </a>
          </li>
          @foreach($moduleLinks as $link)
            <li class="nav-item">
              <a  href="{{ $link['url'] }}">
                @if($link['icon'])<i class="{{ $link['icon'] }}"></i>@endif <span class="nav-label">{{ trans($link['title']) }}</span>
              </a>
            </li>
          @endforeach
          <li class="nav-item">
            <a  href="{{url('/account/logout')}}" data-placement="bottom"
               title="Sign Out">
              <i class="fas fa-sign-out-alt mr-1"></i>
              <span class="nav-label">{{trans('iprofile::frontend.button.sign_out')}}</span>
            </a>
          </li>
        
        </ul>

  @else

        <ul class="list-sidebar bg-default">
          @foreach($moduleLinksWithoutSession as $link)
            <li class="nav-item">
            <a  href="{{$link['url']}}" {{isset($link["dispatchModal"]) ? "data-toggle=modal data-target=".$link['dispatchModal'] : ''}}>
              @if($link['icon'])<i class="{{ $link['icon'] }}"></i>@endif <span class="nav-label">{{ trans($link['title']) }}</span>
            </a>
            </li>
          @endforeach
        
        </ul>
   
  @endif
  
  @if($openLoginInModal)
  <!-- User login modal -->
    <div class="modal fade" id="userLoginModal" tabindex="-1" aria-labelledby="userLoginModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="userLoginModalLabel">{{ trans('user::auth.login') }}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            @include('iprofile::frontend.widgets.login',["embedded" => true, "register" => false])
          </div>
        </div>
      </div>
    </div>
  @endif
  
  @if($openRegisterInModal)
  <!-- User register modal -->
    <div class="modal fade" id="userRegisterModal" tabindex="-1" aria-labelledby="userRegisterModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="userRegisterModalLabel">{{ trans('user::auth.register') }}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            @include('iprofile::frontend.widgets.register',["embedded" => true])
          </div>
        </div>
      </div>
    </div>
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
