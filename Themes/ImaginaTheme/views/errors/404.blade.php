@extends('layouts.master')

@section('title')
    Error 404 | @parent
    @stop

    @section('content')
        <div class="container error">
            <div class="row content">
                <div class="col-xs-12 col-sm-3 col-md-3 col-sm-offset-1 col-md-offset-1 col-lg-offset-1 column1">
                    <i class="fa fa-exclamation-triangle" style="font-size:48px;color:#df1f26"></i>
                </div>
                <div class="col-xs-12 col-sm-5 col-md-5 column2">
                    <div class="" id="error"><h2>Error</h2>&nbsp;&nbsp;&nbsp; <span>4</span>&nbsp; <span>0</span>&nbsp; <span>4</span></div>
                    <div class="" id="message">Lo sentimos, esta página no esta disponible.</div>
                </div>
            </div>
            <div class="row info">
                <div class="col-xs-8 col-xs-offset-3 col-sm-4 col-md-4 col-sm-offset-5 col-md-offset-5 column3">
                    <div class="" id="oop">...Ooops...</div>
                    <!-- <div class="globe" id="globe"><p>Intenta más adelante</p></div> -->
                </div>
            </div>
            <div class="row circle">
                <div class="col-xs-12 col-sm-4 col-md-4 col-sm-offset-4 col-md-offset-4 column4">
                    <div class="globe" id="globe"><p>Intenta más adelante</p></div>
                </div>
            </div>
            <div class="content">
                <div class="title"></div>
            </div>
        </div>
    @stop

@section('scripts')

@stop
