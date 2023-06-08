@extends('iprofile::frontend.layouts.master')
@section('profileBreadcrumb')
    <x-isite::breadcrumb>
        <li class="breadcrumb-item active" aria-current="page">{{ trans('iplan::common.title.my-qrs') }}</li>
    </x-isite::breadcrumb>
@endsection

@section('profileTitle')
    {{ trans('iplan::common.title.my-qrs') }}
@endsection
@section('profileContent')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="my-2 text-right">
                    <x-isite::print-button containerId="qrPrint" icon="fa fa-file-pdf-o" text="{{ trans('iplan::common.title.print') }}" />
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12" id="qrPrint">
                <div class="w-100">
                    <div class="row">
                        <div class="col-xs-12 col-sm-8">
                            <div class="row justify-content-between">
                                <div class="order-1 order-lg-0 col-12 col-md-6 col-lg-9">
                                    <h6 id="extraFieldsTitle" class="profile-section-title font-weight-bold">{{trans('iprofile::frontend.form.Basic')}}</h6>
                                    <hr class="border-top-dotted">
                                    <div class="px-3 row">
                                        <div class="col-12">
                                            <label for="email" class="font-weight-bold">{{trans('user::users.form.email')}}</label>
                                            <div class="d-block mb-3 ml-1"><span>{{$user->email}}</span></div>
                                        </div>
                                        <div class="col-6">
                                            <label class="font-weight-bold">{{ trans('user::users.form.first-name') }}</label>
                                            <div class="d-block mb-3 ml-1"><span>{{$user->first_name}}</span></div>
                                        </div>
                                        <div class="col-6">
                                            <label class="font-weight-bold">{{ trans('user::users.form.last-name') }}</label>
                                            <div class="d-block mb-3 ml-1"><span>{{$user->last_name}}</span></div>
                                        </div>
                                    </div>
                                    @if(!empty($user->fields->isNotEmpty()))
                                        <h6 id="extraFieldsTitle" class="profile-section-title font-weight-bold">{{trans('iprofile::frontend.title.extraFields')}}</h6>
                                        <hr class="border-top-dotted">
                                        @php
                                            $registerExtraFields = json_decode(setting('iprofile::registerExtraFields', null, "[]"));
                                        @endphp
                                        @foreach($registerExtraFields as $extraField)
                                            @php
                                                $oldValue = $fields[$extraField->field] ?? '--';
                                            @endphp
                                            {{-- if is active--}}
                                            @if(isset($extraField->active) && $extraField->active)
                                                {{-- form group--}}
                                                <div class="col-sm-12 col-md-6 py-2 has-feedback">
                                                    {{-- label --}}
                                                    <label for="extraField{{$extraField->field}}" class="font-weight-bold">
                                                        @if(isset($extraField->label))
                                                            {{$extraField->label}}
                                                        @else
                                                            {{trans("iprofile::frontend.form.$extraField->field")}}
                                                        @endif
                                                    </label>
                                                    <div>
                                                        {{ $oldValue }}
                                                    </div>
                                                </div>
                                                @if($extraField->field == 'documentType')
                                                    {{-- form group--}}
                                                    <div class="col-sm-12 col-md-6 py-2 has-feedback">
                                                        {{-- label --}}
                                                        <label for="extraFielddocumentNumber" class="font-weight-bold">{{trans("iprofile::frontend.form.documentNumber")}}</label>
                                                        <div>
                                                            {{ $fields['documentNumber'] }}
                                                        </div>
                                                    </div>
                                                @endif
                                            @endif {{-- end if is active --}}
                                        @endforeach
                                    @endif
                                </div>
                                <div class="col-12 col-md-4 col-lg-3 py-2 d-print-none text-center">
                                    @php $defaultImage = url("modules/iprofile/img/default.jpg"); @endphp
                                    <div class="img-frame mx-auto w-75">
                                        @if(isset($fields['mainImage']) &&  !empty($fields['mainImage']) && $fields['mainImage']!=null )
                                            <img id="mainImage" class="mx-auto img-fluid rounded-circle bg-white" src="{{ url($fields['mainImage']).'?'.strtotime(now()) }}" alt="Logo" >
                                        @else
                                            <img id="mainImage" class="mx-auto img-fluid rounded-circle bg-white" src="{{$defaultImage}}" alt="Logo">
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-4 text-center">
                            <div class="my-2 px-4">
                                @php
                                    $qrs = $user->qrs()->where('zone','subscriptions')->get();
                                @endphp
                                @foreach($qrs as $qr)
                                    <img src="{{ $qr->code }}" />
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

