

<div class="container">
    <div class="row ">
        <div class="col-12 mb-5">

            @if(!isset($embedded))
                <div class="title">
                    <h1 class="text-primary">{{ trans('user::auth.register') }} </h1>
                </div>
            @endif

            @if(setting("iprofile::registerUsersWithSocialNetworks"))
                <div class="border-top title border-bottom border-top-dotted border-bottom-dotted py-4 {{isset($embedded) ? '' : 'mt-4'}} mb-4">
                    <p>{{trans('iprofile::frontend.title.social msj register')}}</p>
                    <div class="d-inline-block mr-3 mb-3">
                        <a href="{{route('account.social.auth',['facebook']).((isset($route) && !empty(isset($route))) ? "?redirect=".route($route) : "")}}"><img class="img-fluid" src="{{url('modules/iprofile/img/facebook.png')}}" alt="Facebook"></a>

                    </div>
                    <div class="d-inline-block">
                        <a href="{{route('account.social.auth',['google']).((isset($route) && !empty(isset($route))) ? "?redirect=".route($route) : "")}}"><img class="img-fluid" src="{{url('modules/iprofile/img/google.png')}}" alt="Google"></a>

                    </div>
                </div>

                <div class="">
                    <p class="mb-4">{{trans('iprofile::frontend.title.social msj register 2')}}</p>
                </div>
            @endif
            @include('isite::frontend.partials.notifications')

            <hr class="border-top-dotted">

            {!! Form::open(['url' => tenant_route(request()->getHost(), 'account.register.post'), 'class' => 'form-content','autocomplete' => 'off', 'id' => 'registerForm']) !!}

            @if(isset($embedded))

                <input name="embedded" type="hidden" value="{{isset($route) && $route ? $route : ''}}">
            @endif
            <div class="px-2 px-sm-0">
                <div class="row">

                    <div class="col-sm-12 {{isset($embedded) ? '' : 'col-md-6' }} py-2 has-feedback {{ $errors->has('first_name') ? ' has-error' : '' }}">
                        <label>{{trans('user::users.form.first-name')}}</label>
                        {{ Form::text('first_name', old('first_name'),["minlength" => 3,'required'=>true,'class'=>"form-control",'placeholder' => '...']) }}
                        {!! $errors->first('first_name', '<div class="invalid-feedback">:message</div>') !!}
                    </div>

                    <div class="col-sm-12 {{isset($embedded) ? '' : 'col-md-6' }} py-2 has-feedback {{ $errors->has('last_name') ? ' has-error' : '' }}">
                        <label>{{trans('user::users.form.last-name')}}</label>
                        {{ Form::text('last_name', old('last_name'),["minlength" => 3,'required'=>true,'class'=>"form-control",'placeholder' => '...']) }}
                        {!! $errors->first('last_name', '<div class="invalid-feedback">:message</div>') !!}
                    </div>

                    <div class="col-sm-12 {{isset($embedded) ? '' : 'col-md-6' }} py-2 has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">
                        <label>Email</label>
                        {{ Form::email('email', old('email'),['required'=>true,'class'=>"form-control",'placeholder' => '...']) }}
                        {!! $errors->first('email', '<div class="invalid-feedback">:message</div>') !!}
                    </div>


                    <div class="col-sm-12 {{isset($embedded) ? '' : 'col-md-6' }} py-2 has-feedback {{ $errors->has('password') ? ' has-error' : '' }}">
                        <label>{{trans('user::users.form.password')}}</label>
                        {{ Form::password('password',['required'=>true,'class'=>'form-control','placeholder' => '...']) }}
                        {!! $errors->first('password', '<div class="invalid-feedback">:message</div>') !!}
                    </div>
                    <div class="col-sm-12 {{isset($embedded) ? '' : 'col-md-6' }} py-2 has-feedback {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                        <label>{{trans('iprofile::frontend.title.password confirmation')}}</label>
                        {{ Form::password('password_confirmation',['required'=>true,'class'=>'form-control','placeholder' => '...']) }}
                        {!! $errors->first('password_confirmation', '<div class="invalid-feedback">:message</div>') !!}
                    </div>

                    @php
                        $registerExtraFields = json_decode(setting('iprofile::registerExtraFields', null, "[]"));
                    @endphp
                    @foreach($registerExtraFields as $extraField)
                        {{-- if is active--}}
                        @if(isset($extraField->active) && $extraField->active)

                            {{-- form group--}}
                            <div class="col-sm-12 {{isset($embedded) ? '' : 'col-md-6' }} py-2 has-feedback {{ $errors->has($extraField->field) ? ' has-error' : '' }}">

                                {{-- label --}}
                                <label for="extraField{{$extraField->field}}">
                                  @if(isset($extraField->label))
                                    {{$extraField->label}}
                                  @else
                                    {{trans("iprofile::frontend.form.$extraField->field")}}
                                  @endif
                                </label>


                                {{-- Generic input --}}
                                @if( !in_array($extraField->type, ["select","textarea"]) )

                                    {{-- Text input --}}
                                    @if(in_array($extraField->type ,["text","number","checkbox","password","date"]))
                                      <input  type="{{$extraField->type}}" name="fields[{{$extraField->field}}]" required="{{$extraField->required}}" class ="form-control" id = 'extraField{{$extraField->field}}'/>
                                    @endif



                                    {{-- Custom documentType input --}}
                                    @if($extraField->type == "documentType")

                                            {{-- foreach options --}}
                                            @if(isset($extraField->availableOptions) && is_array($extraField->availableOptions) && count($extraField->availableOptions))
                                                @if(isset($extraField->availableOptions) && isset($extraField->options))
                                                    @php($optionValues = [])
                                                    @foreach($extraField->availableOptions as $availableOption)
                                                        {{-- finding if the availableOption exist in the options and get the full option object --}}
                                                        @foreach ($extraField->options as $option)
                                                            @if($option->value == $availableOption)
                                                                @php($optionValues = array_merge($optionValues, [ $option->value => $option->label]))
                                                            @endif
                                                        @endforeach
                                                    @endforeach
                                                @endif
                                            @else
                                            @php($optionValues = [])
                                            @foreach ($extraField->options as $option)
                                                    @php($optionValues = array_merge($optionValues, [ $option->value => $option->label]))
                                            @endforeach

                                            @endif

                                            @if(isset($optionValues))
                                                {{-- Select --}}

                                            {{Form::select("fields[$extraField->field]", $optionValues, null, ['id'=>'extraField'.$extraField->field, 'required'=>$extraField->required,'class'=>"form-control",'placeholder' => '']) }}
                                            @endif
                                            </div>

                                            <div class="col-sm-12 {{isset($embedded) ? '' : 'col-md-6' }} py-2 has-feedback {{ $errors->has($extraField->field) ? ' has-error' : '' }}">
                                                <label for="extraFieldDocumentNumber">{{trans("iprofile::frontend.form.documentNumber")}}</label>
                                              <input  type="number" minlength="6" min="100000" max="9999999999" name="fields[documentNumber]" required="{{$extraField->required}}" class ="form-control" id = 'extraFieldDocumentNumber'/>

                                    @endif

                                @else
                                    {{-- if is select --}}
                                    @if($extraField->type == "select")

                                        {{-- foreach options --}}
                                    @if(isset($extraField->availableOptions) && is_array($extraField->availableOptions) && count($extraField->availableOptions))
                                        @if(isset($extraField->availableOptions) && isset($extraField->options))
                                            @php($optionValues = [])
                                            @foreach($extraField->availableOptions as $availableOption)
                                                {{-- finding if the availableOption exist in the options and get the full option object --}}
                                                @foreach ($extraField->options as $option)
                                                    @if($option->value == $availableOption)
                                                        @php($optionValues = array_merge($optionValues, [ $option->value => $option->label]))
                                                    @endif
                                                @endforeach
                                            @endforeach
                                        @endif
                                    @else
                                            @php($optionValues = $extraField->options)
                                    @endif

                                        @if(isset($optionValues))
                                            {{-- Select --}}
                                            {{Form::select("fields[$extraField->field]", $optionValues, null, ['id'=>'extraField'.$extraField->field, 'required'=>$extraField->required,'class'=>"form-control",'placeholder' => '']) }}
                                        @endif
                                    @else
                                        {{-- if is textarea --}}
                                        @if($extraField->type == "textarea")
                                            {{-- Textarea --}}
                                            {{ Form::textarea("fields[$extraField->field]", old($extraField->field),['id'=>'extraField'.$extraField->field,'required'=>$extraField->required,'class'=>"form-control",'placeholder' => '', "cols" => 30, "rows" => 3]) }}

                                        @endif {{--- end if is textarea --}}
                                    @endif {{-- end if is select --}}
                                @endif {{-- end if is generic input --}}
                            </div>
                        @endif {{-- end if is active --}}
                    @endforeach


                </div>

                <hr class="border-top-dotted my-4">

                <div class="row">
                    <div class="col-sm-12 {{isset($embedded) ? '' : 'col-md-6' }}">

                        @if(json_decode(setting('iprofile::registerUserWithPoliticsOfPrivacy', null, "true")))
                            <div class="custom-control custom-radio red mb-3">
                                <input type="radio" class="custom-control-input"
                                       id="customradio-select1" name="confirmPolytics" value="1" required>
                                <label class="custom-control-label" for="customradio-select1">
                                    {!!  trans('icommerce::customer.form.confirmPolytics',["url" => url(trans("iprofile::frontend.button.privacy_policy_url"))])  !!}
                                </label>
                            </div>
                        @endif
                    </div>
                    <x-isite::captcha formId="registerForm" />
                    <div class="col-sm-12 {{isset($embedded) ? '' : 'col-md-6' }} pt-4 pt-lg-0">
                        <input class="btn btn-primary text-white text-uppercase font-weight-bold rounded-pill px-3 py-2"
                               type="submit" value="{{ trans('core::core.button.create') }}" {{ setting('isite::activateCaptcha') ? 'disabled' : '' }}>
                    </div>
                </div>

            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
