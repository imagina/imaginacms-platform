@extends('layouts.master')

@section('meta')
    @include('iblog::frontend.partials.category.metas')
@stop
@section('title')
    {{$category->title}} | @parent
@stop
@section('content')
    <div class="blog-category-{{$category->id}}">
        <div class="container">

            <div class="row">

                <!-- Blog Entries Column -->
                <div class="col-md-8">

                    <h1 class="my-4">{{$category->title}}
                    </h1>
                    <p>{{$category->description}}</p>

                @if (count($posts))
                    @foreach($posts as $post)
                        <!-- Blog Post -->
                            <div class="card mb-4">
                                <img class="card-img-top"
                                     src="{{--str_replace('.jpg','_mediumThumb.jpg',$post->mainimage->path)--}}{{$post->mainimage->path}}"
                                     alt="{{$post->title}}">
                                <div class="card-body">
                                    <h2 class="card-title">{{$post->title}}e</h2>
                                    <p class="card-text">{{$post->summary}}</p>
                                    <a href="{{$post->url}}"
                                       class="btn btn-primary">{{trans('iblog::common.button.read more')}} &rarr;</a>
                                </div>
                                <div class="card-footer text-muted">
                                    {{trans('iblog::common.Posted on')}} {{format_date($post->created_at,'%m %d, %G')}} {{trans('iblog::common.by')}}
                                    <a href="{{$post->url}}">{{$post->user->present()->fullName()}}</a>
                                </div>
                            </div>
                    @endforeach

                <!-- Pagination -->
                    <div class="pagination justify-content-center mb-4 pagination paginacion-blog row">
                        <div class="pull-right">
                            {{$posts->links('pagination::bootstrap-4')}}
                        </div>
                    </div>
                    @else
                        <div class="col-xs-12 con-sm-12">
                            <div class="white-box">
                                <h3>Ups... :(</h3>
                                <h1>404 Post no encontrado</h1>
                                <hr>
                                <p style="text-align: center;">No hemos podido encontrar el Contenido que estás
                                    buscando.</p>
                            </div>
                            @endif

                        </div>

                        <!-- Sidebar Widgets Column -->
                        <div class="col-md-4">

                            <!-- Search Widget -->
                            <div class="card my-4">
                                <h5 class="card-header">Search</h5>
                                <div class="card-body">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Search for...">
                                        <span class="input-group-btn">
                <button class="btn btn-secondary" type="button">Go!</button>
              </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Categories Widget -->
                            <div class="card my-4">
                                <h5 class="card-header">{{trans('iblog::category.list')}}</h5>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <ul class="list-unstyled mb-0">
                                                @if(count($category->children))
                                                    @foreach($category->children as $subcategory)
                                                <li>
                                                    <a href="{{$subcategory->url}}">{{$subcategory->title}}</a>
                                                </li>
                                                    @endforeach
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Side Widget -->
                            <div class="card my-4">
                                <h5 class="card-header">Side Widget</h5>
                                <div class="card-body">
                                    You can put anything you want inside of these side widgets. They are easy to use,
                                    and
                                    feature the new Bootstrap 4 card containers!
                                </div>
                            </div>

                        </div>

                </div>
                <!-- /.row -->

            </div>

            <div class="page blog blog-revista blog-category-{{$category->slug}} blog-category-{{$category->id}}">
                <div class="container">
                    <div class="row fondo1 sombra-interna">
                        <div class="col-xs-12">
                            <div class="titulo-2">
                                <h2>
                                    <i class="fa fa-caret-right" aria-hidden="true"></i>
                                    {{$category->title}}
                                </h2>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-8 category-body-1 column1">
                            <div class="row">
                                @if (count($posts) !=0)
                                    @php $cont = 0; @endphp
                                    @foreach($posts as $post)
                                        <div class="col-xs-6 col-sm-4 contend post post{{$post->id}}">
                                            <div class="bg-imagen">
                                                <a href="{{$post->url}}">
                                                    <img class="image img-responsive"
                                                         src="{{url(str_replace('.jpg','_mediumThumb.jpg',$post->mainimage->path))}}"
                                                         alt="{{$post->title}}"/>
                                                </a>
                                            </div>
                                            @foreach($post->categories as $category)
                                                {{$category->title}}
                                            @endforeach
                                            <div class="content">
                                                <a href="{{$post->url}}"><h2>{{$post->title}}</h2></a>
                                                <p>{!! $post->summary!!}</p>
                                                <a class="btn btn-primary post-link" href="{{$post->url}}">Ver Mas<span
                                                            class="glyphicon glyphicon-chevron-right"></span></a>
                                            </div>
                                        </div>
                                        @php $cont++; @endphp
                                        @if($cont%3==0)
                                            <div class="clearfix" style="margin:10px 0"></div>
                                        @endif
                                    @endforeach

                                    <div class="clearfix"></div>
                                    <div class="pagination paginacion-blog row">
                                        <div class="pull-right">
                                            {{$posts->links('pagination::bootstrap-4')}}
                                        </div>
                                    </div>
                                @else
                                    <div class="col-xs-12 con-sm-12">
                                        <div class="white-box">
                                            <h3>Ups... :(</h3>
                                            <h1>404 Post no encontrado</h1>
                                            <hr>
                                            <p style="text-align: center;">No hemos podido encontrar el Contenido que
                                                estás
                                                buscando.</p>
                                        </div>
                                        @endif
                                    </div>
                            </div>

                            <div class="col-xs-12 col-sm-3 col-sm-offset-1 column2">

                                <div class="sidebar-revista">

                                    <div class="cate">
                                        <h3>Categorias</h3>
                                        <button type="submit"></button>

                                        {{--<div class="listado-cat">
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
                                        </div>--}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
@stop
