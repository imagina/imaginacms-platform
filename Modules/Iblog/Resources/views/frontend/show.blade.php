@extends('layouts.master')

@section('meta')
    @include('iblog::frontend.partials.post.metas')
@stop

@section('title')
    {{ $post->title }} | @parent
@stop

@section('content')


   <article id="post{{$post->id}}" class="post blog single single-{{$category->slug}} single-{{$category->id}}">
        <div class="container" id="body-wrapper">
            <div class="row">
                <div class="col-xs-12 col-sm-9 column1">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="bgimg">
                                <img class="image img-responsive" src="{{url($post->mainimage->path)}}"
                                     alt="{{$post->title}}"/>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="content col-xs-12 col-sm-10 ">
                            <h1>{{ $post->title }}</h1>
                            {!! $post->description !!}

                            @if(!$tags->isEmpty())
                                <div class="tag">
                                <span class="tags-links">
                                    @foreach($tags as $tag)
                                        <a href="{{$tag->url}}" rel="tag">{{$tag->title}}</a>
                                    @endforeach
                                </span>
                                </div>
                            @endif
                        </div>
                        <div class="content col-xs-12 col-sm-10">
                            @include('iblog::frontend.gallery.viewline')
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="social">
                                {{trans('iblog::common.social.share')}}
                                <div class="sharethis-inline-share-buttons"></div>
                            </div>
                        </div>
                    </div>
                    <div class="facebook-comments">
                        <div class="fb-comments"
                             data-href="{{url($post->url)}}"
                             data-numposts="5" data-width="100%">
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
    </article>
@stop

@section('scripts')
    @parent
    @include('iblog::frontend.partials.post.script')
@stop