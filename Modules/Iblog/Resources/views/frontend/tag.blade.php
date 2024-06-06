@extends('layouts.master')

@section('meta')
    <meta name="description" content="@if(!empty($tag->description)){!!$tag->description!!}@endif">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="">
    <meta name="twitter:title" content="{{$tag->title}}">
    <meta name="twitter:description" content="{@if(!empty($tag->description)){!!$tag->description  !!}@endif">
    <meta name="twitter:creator" content="">
    <meta name="twitter:image:src"
          content="@if(!empty($tag->options->mainimage)){{url($tag->options->mainimage) }} @endif">
@stop
@section('title')
    {{$tag->title}} | @parent
@stop
@section('content')
    <div class="page blog blog-revista blog-category-{{$tag->slug}} blog-category-{{$tag->id}}">
        <div class="container">
            <div class="row fondo1 sombra-interna">
                <div class="col-xs-12">
                    <div class="titulo-2">
                        <h2>
                            <i class="fa fa-caret-right" aria-hidden="true"></i>
                            {{$tag->title}}
                        </h2>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-8 category-body-1 column1">
                    <div class="row">
                    @if (!empty($posts))
                        @php $cont = 0; @endphp

                        @foreach($posts as $post)
                            <!-- Blog Post -->
                                <div class="col-xs-6 col-sm-3 contend post post{{$post->id}}">
                                    <div class="bg-imagen">
                                        <a href="{{ $post->url }}">
                                            <img class="image img-responsive"
                                                 src="{{url(str_replace('.jpg','_mediumThumb.jpg',$post->mainimage->path))}}"
                                                 alt="{{$post->title}}"/>
                                        </a>
                                    </div>
                                    <div class="content">
                                        <a href="{{$post->url}}"><h4> {{$post->title}}</h4></a>
                                        <p>{!!$post->summary!!}</p>
                                        <a class="btn btn-primary post-link" href="{{$post->url}}">Ver Mas<span
                                                    class="glyphicon glyphicon-chevron-right"></span></a>
                                    </div>
                                </div>
                                @php $cont++; @endphp
                                @if($cont%2==0)
                                    <div class="clearfix"></div>
                                @endif

                            @endforeach

                            <div class="clearfix"></div>

                            <div class="pagination paginacion-blog row">
                                <div class="pull-right">
                                    {{ $posts->links() }}
                                </div>
                            </div>

                        @endif
                    </div>
                </div>
                <div class="col-xs-12 col-sm-3 col-sm-offset-1 column2">
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