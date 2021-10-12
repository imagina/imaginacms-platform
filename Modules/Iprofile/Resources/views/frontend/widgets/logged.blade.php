<!--- LOGIN -->
@if(Auth::user())
@php
$mainImage=\Modules\Iprofile\Entities\Field::where('user_id',Auth::user()->id)->where('name','mainImage')->first();
@endphp
    <div class="account-menu dropdown mx-1" id="accMenuDrop">
        <a class="btn btn-outline-secondary border-0 dropdown-toggle" href="#" role="button" id="dropdownUser" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            @if($mainImage)
                <img class="i-circle" style="margin-top: -5px; width: 20px;"
                     src="{{url($mainImage->value)}}"/>
            @else
                <img class="i-circle" style="margin-top: -5px; width: 20px;"
                     src="{{url('modules/iprofile/img/default.jpg')}}"/>
            @endif

               {{trans("iprofile::frontend.title.my_account")}}
        </a>

        <div id="drop-menu" class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownUser">
            <div class="dropdown-item text-center ">
                <!-- Nombre -->
                {{trans("iprofile::frontend.title.welcome")}}
                <span class="username text-truncate aling-middle">
                    <?php if ($user->first_name != ' '): ?>
                        <?= $user->first_name; ?>
                    <?php else: ?>
                        <em>{{trans('core::core.general.complete your profile')}}.</em>
                    <?php endif; ?>
                </span>
            </div>
            <a class="dropdown-item"  href="{{url('/account')}}">
                <i class="fa fa-user mr-2"></i>{{trans('iprofile::frontend.title.profile')}}
            </a>
            @if(is_module_enabled('Icommerce'))
            <a class="dropdown-item"  href="{{url('/orders')}}">
                <i class="fa fa-bars mr-2"></i> {{trans("icommerce::orders.title.orders")}}
            </a>
            @endif
            <a class="dropdown-item" href="{{url('/account/logout')}}" data-placement="bottom"
               title="Sign Out">
                <i class="fa fa-sign-out mr-1"></i>
                <span class="d-none d-lg-inline-block">{{trans('iprofile::frontend.button.sign_out')}}</span>
            </a>
        </div>
    </div>
@else
    <div class="account-menu dropdown" id="accMenuDrop">
        <a class="btn btn-outline-secondary border-0 dropdown-toggle" href="#" role="button" id="dropdownUser" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-user mr-1"></i>{{trans("iprofile::frontend.title.my_account")}}
        </a>

        <div id="drop-menu" class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownUser">
            <a class="dropdown-item" href="{{route('login')}}">
                <i class="fa fa-user mr-2"></i>{{trans('iprofile::frontend.button.sign_in')}}
            </a>
             <a class="dropdown-item" href="{{route('account.register')}}">
                <i class="fa fa-sign-out mr-2"></i>{{trans('iprofile::frontend.button.register')}}
            </a>
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
