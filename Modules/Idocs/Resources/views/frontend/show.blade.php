@extends('layouts.master')

@section('meta')
    @include('idocs::frontend.partials.post.metas')
@stop

@section('title')
    {{ $document->title }} | @parent
@stop

@section('content')


   <div class="page blog single single-{{$category->slug}} single-{{$category->id}}">
        <div class="container" id="body-wrapper">
            <div class="row">
                <div class="col-xs-12 col-sm-9 column1">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="bgimg">
                                <img class="image img-responsive" src="{{url($document->mainimage->path)}}"
                                     alt="{{$document->title}}"/>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="content col-xs-12 col-sm-10 ">
                            <h2>{{ $document->title }}</h2>
                            {!! $document->description !!}
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-3 column2">
                    <div class="sidebar-revista">
                        <div class="cate">
                            <h3>Categorias</h3>

                            <div class="listado-cat">
                                <ul>
                                    @php
                                        $categories=get_categories();
                                    @endphp

                                    @if(isset($categories))
                                        @foreach($categories as $index=>$category)
                                            <li><a href="{{url($category->slug)}}">{{$category->title}}</a></li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    @parent
    @include('Idocs::frontend.partials.docs.script')
@stop