@extends('layouts.master')

@section('title')
    {{ trans('user::auth.reset password') }} | @parent
@stop

@section('content')

{{-- Need Publish --}}
<link href="{!! Module::asset('iprofile:css/base.css') !!}" rel="stylesheet" type="text/css" />

    <div class="page page-profile py-5">


        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-8 col-lg-6">

                    <div class="title">
                        <h1 class="text-primary">{{ trans('user::auth.reset password') }}</h1>
                    </div>
                    <div class="border-top title border-bottom border-top-dotted border-bottom-dotted py-4 mt-4 mb-4">
                        <p class="mb-0">{{ trans('user::auth.to reset password complete this form') }}</p>
                    </div>

                    <div class="formulario">
                        @include('isite::frontend.partials.notifications')

                        {!! Form::open(['route' => 'account.reset.post']) !!}
                        <div class="form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label for="email">{{ trans('user::auth.email') }}</label>
                                    <input type="email" class="form-control" autofocus
                                           name="email" value="{{ old('email')}}" required>
                                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                                    {!! $errors->first('email', '<div class="invalid-feedback">:message</span>') !!}
                        </div>

                        <div class="row">
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-primary text-uppercase text-white font-weight-bold rounded-pill px-3 py-2 mt-4">
                                    {{ trans('user::auth.reset password') }}
                                </button>
                            </div>
                        </div>
                        {!! Form::close() !!}

                        <hr class="border-top-0 border-bottom  border-bottom-dotted pb-4 mb-4">
                        <p class="text-center">
                            <a href="{{ route('account.login.get') }}"
                               class="text-center">{{ trans('user::auth.I remembered my password') }}</a>
                        </p>
                    </div>

                </div>
            </div>
        </div>

    </div>

    {{--

    <div class="iprofile iprofile-reset iprofile-border">
        <div class="container">
            <div class="row">

                <div class="col-xs-12 col-sm-6 col-sm-offset-2 mx-auto">

                    <div class="bloque-reset">

                        <div class="login-box-body">

                            <span class="title">Reiniciar contraseña</span>

                            <div class="formulario">
                                <p class="login-box-msg">{{ trans('user::auth.to reset password complete this form') }}</p>
                                @include('isite::frontend.partials.notifications')

                                {!! Form::open(['route' => 'account.reset.post']) !!}
                                <div class="form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label for="email">{{ trans('user::auth.email') }}</label>
                                        </div>
                                        <div class="col-sm-8">
                                            <input type="email" class="form-control" autofocus
                                                   name="email" value="{{ old('email')}}" required>
                                            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                                            {!! $errors->first('email', '<span class="help-block">:message</span>') !!}
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xs-12">
                                        <button type="submit" class="btn btn-success  btn-flat pull-right">
                                            {{ trans('user::auth.reset password') }}
                                        </button>
                                    </div>
                                </div>
                                {!! Form::close() !!}

                                <hr>
                                <p class="text-center">
                                    <a href="{{ route('login') }}"
                                       class="text-center">{{ trans('user::auth.I remembered my password') }}</a>
                                </p>
                            </div>

                        </div>
                        <div class="clearfix"></div>

                    </div>

                </div>
            </div>
            <hr>
        </div>
    </div>

--}}
@stop
