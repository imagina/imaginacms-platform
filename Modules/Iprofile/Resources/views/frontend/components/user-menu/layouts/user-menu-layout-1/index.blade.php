<div id="{{ $id }}" class="d-inline-block">
    <!--- LOGIN -->
    @if($user)
        @php
          $userData = $user['data'];
        @endphp
        <div  class="account-menu dropdown d-inline-block" id="accMenuDrop">
            <button class="btn dropdown-toggle" type="button"
                    id="dropdownProfile" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">


                @if($showLabel)
                    <span class="username text-truncate aling-middle text-capitalize">
                            <?php if ($userData->firstName != ' '): ?>
                                <?= $userData->firstName; ?>
                            <?php else: ?>
                                <em>{{trans('core::core.general.complete your profile')}}.</em>
                            <?php endif; ?>
                    </span>
                @else
                    <i class="fa fa-user" aria-hidden="true"></i>
                @endif
            </button>
            <div id="drop-menu" class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownUser">
                <div class="dropdown-item text-center py-3 ">
                    <!-- Nombre -->
                    @if($userData->mainImage)
                        <img class="i-circle d-inline-block rounded-circle border border-dark" style="width: 20px;"
                             src="{{$userData->mainImage}}"/>
                    @else
                        <img class="i-circle d-inline-block rounded-circle border border-dark" style="width: 20px;"
                             src="{{url('modules/iprofile/img/default.jpg')}}"/>
                    @endif

                    <span class="username text-truncate aling-middle text-capitalize">
                    <?php if ($userData->firstName != ' '): ?>
                        <?= $userData->firstName; ?>
                    <?php else: ?>
                        <em>{{trans('core::core.general.complete your profile')}}.</em>
                    <?php endif; ?>
                    </span>
                </div>

                <a class="dropdown-item"  href="{{\URL::route(\LaravelLocalization::getCurrentLocale() . '.iprofile.account.index')}}">
                    <i class="fa fa-user mr-2"></i> {{trans('iprofile::frontend.title.profile')}}
                </a>
                @foreach($moduleLinks as $link)
                    <a class="dropdown-item"  href="{{ route($link['routeName']) }}">
                        @if($link['icon'])<i class="{{ $link['icon'] }}"></i>@endif {{ trans($link['title']) }}
                    </a>
                @endforeach
                <a class="dropdown-item" href="{{url('/account/logout')}}" data-placement="bottom"
                   title="Sign Out">
                    <i class="fa fa-sign-out mr-1"></i>
                    <span>{{trans('iprofile::frontend.button.sign_out')}}</span>
                </a>
            </div>

        </div>
    @else
        <div class="account-menu dropdown d-inline-block" id="accMenuDrop">
            <button class="btn  dropdown-toggle" type="button"
                    id="dropdownProfile" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                <div class="user d-inline-block">
                    @if($showLabel)
                        <span class="d-md-none d-lg-inline-block"> {{ trans('iprofile::frontend.button.my_account') }}</span>
                    @endif
                    <i class="fa fa-user" aria-hidden="true"></i>
                </div>
            </button>

            <div id="drop-menu" class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownUser">
                <a class="dropdown-item"
                {{$openLoginInModal ? "data-toggle=modal data-target=#userLoginModal href=".route('account.login.get')."" : ''}}
                >
                    <i class="fa fa-user mr-2"></i>{{trans('iprofile::frontend.button.sign_in')}}
                </a>
                <a class="dropdown-item" href="{{route('account.register')}}"
                {{$openRegisterInModal ? "data-toggle=modal data-target=#userRegisterModal  href=".route('account.register')."" : ''}}

                >
                    <i class="fa fa-sign-out mr-2"></i>{{trans('iprofile::frontend.button.register')}}
                </a>
            </div>
        </div>
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
