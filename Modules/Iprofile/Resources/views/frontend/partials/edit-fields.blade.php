@php
    $op = array('required' => 'required', 'autocomplete' => 'off', "minlength" => 3);
@endphp


    <div class="row">
        <div class="order-1 order-lg-0 col-sm-12 col-md-6 ">
            
            <h6 id="extraFieldsTitle" class="profile-section-title">{{trans('iprofile::frontend.form.Basic')}}</h6>

            <hr class="border-top-dotted">
            <div class="px-3">

                {!! Form::open(['route' => ['iprofile.profile.update', $user->id], 'method' => 'put']) !!}

                <input type="hidden" id="token" name="_token" value="{{csrf_token()}}">

                {{ Form::normalInput('email', trans('user::users.form.email'), $errors, $user,$op) }}

                {{ Form::normalInput('first_name', trans('user::users.form.first-name'), $errors, $user,$op) }}

                {{ Form::normalInput('last_name', trans('user::users.form.last-name'), $errors, $user,$op) }}

            </div>
            @if(!empty($user->fields->isNotEmpty()))

            <h6 id="extraFieldsTitle" class="profile-section-title">{{trans('iprofile::frontend.title.extraFields')}}</h6>
            <hr class="border-top-dotted">

            @include('iprofile::frontend.partials.extra-fields-form',["embedded" => true, "fields" => $user->fields])
            @endif
            <div class="col-md-12 col-lg-auto text-center pt-4 pt-lg-0">
                <button type="submit"
                        class="btn btn-sm btn-primary text-white rounded-pill">
                    {{ trans('core::core.button.update') }}
                </button>
            </div>

            {!! Form::close() !!}
        </div>

        <div class="col-sm-12 col-md-6 py-2">
        @php $defaultImage = url("modules/iprofile/img/default.jpg"); @endphp
        @include('iprofile::frontend.partials.image-account',['default' => $defaultImage])

            <div class=" form-button text-center py-2 ">
                {{ link_to(route('account.reset'),trans('iprofile::frontend.title.resetPassword'),[]) }}
            </div>
        </div>



    </div>



