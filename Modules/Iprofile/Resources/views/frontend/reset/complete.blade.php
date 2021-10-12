@extends('layouts.master')

@section('title')
    {{ trans('user::auth.reset password') }} | @parent
@stop

@section('content')

    <div class="page page-profile py-5">

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-8 col-lg-6">

                    <div class="title">
                        <h1 class="text-primary">{{trans('iprofile::frontend.title.resetPassword')}}</h1>
                    </div>
                    <hr class="border-top-dotted">

                    <div class="formulario">

                        <p class="login-box-msg">{{ trans('user::auth.reset password') }}</p>
                        @include('isite::frontend.partials.notifications')

                        {!! Form::open() !!}
                        <div class="form-group has-feedback {{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="">{{ trans('user::auth.password') }}</label>
                                <input type="password" class="form-control" autofocus
                                       name="password" required>
                                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                                {!! $errors->first('password', '<div class="invalid-feedback">:message</div>') !!}
                        </div>
                        <div class="form-group has-feedback {{ $errors->has('password_confirmation') ? ' has-error has-feedback' : '' }}">
                            <label for="">{{ trans('user::auth.password confirmation') }}</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                            <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
                            {!! $errors->first('password_confirmation', '<div class="invalid-feedback">:message</div>') !!}
                        </div>
                        <div class="row">
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-primary text-uppercase text-white font-weight-bold rounded-pill px-3 py-2 mt-4">
                                    {{ trans('user::auth.reset password') }}
                                </button>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>

                    <hr class="border-top-0 border-bottom  border-bottom-dotted pb-4 mb-4">

                </div>
            </div>
        </div>

    </div>

@stop
