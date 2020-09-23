@extends('layouts.master')

@section('meta')
    <meta name="description" content="@if(!empty($category->description)){!!$category->description!!}@endif">
    <!-- Schema.org para Google+ -->
    <meta itemprop="name" content="{{$category->title}}">
    <meta itemprop="description" content="@if(! empty($category->description)){!!$category->description!!} @endif">
    <meta itemprop="image"
          content=" @if(! empty($category->mainimage->path)){{url($category->mainimage->path)}} @endif">

@endsection
@section('content')
@php
    $categories=get_categories(['parent' => $category->id, 'take' => 16, 'order'=> 'asc' ]);
        
@endphp

      @component('partials.widgets.breadcrumb')
       @if(count($category->parent)!=0)
        <li class="breadcrumb-item " aria-current="page"> 
           <a href=" {{$category->parent->url}}"> {{$category->parent->title}}</a>
        </li>
        @endif
        <li class="breadcrumb-item active" aria-current="page"> 
            {{$category->title}}
        </li>                
       @endcomponent
    
    <div class="page blog blog-revista blog-category-{{$category->slug}} blog-category-{{$category->id}}">

    
        <div class="container mt-5">
            
           
            <div class="row content-index">
                <div class="col-12">
                    <h2>{{$category->title}}</h2>
                    
                </div>    
                @if(count($categories)!=0 || count($posts) !=0)
                    @foreach($categories as $post)
                        <div class="col-12 col-md-6 col-lg-4  post pb-5 post{{$post->id}}">
                                <a class="" href="{{$post->url}}" style="background: url({{$post->mainimage->path}})">
                                    <div class="content">
                                    <div class="titulo">                                          
                                        <h5 class="title">{{$post->title,12}}</h5>
                                        <span>Ver Más >></span>
                                    </div>
                                    </div>
                                </a>
                        </div>
                        
                @endforeach
            
                @foreach($posts as $post)
                    <div class="col-12 col-md-6 col-lg-4  post pb-5 post{{$post->id}}">
                        <a class="" href="{{$post->url}}" style="background: url({{$post->mainimage->path}})">
                                <div class="content">    
                                    <div class="titulo">
                                        <h5 class="title">{{$post->title,12}}</h5>   
                                        <span>Ver Más >></span>
                                    </div>
                                    </div>
                                </a>
                    </div>
                    
                @endforeach
                
                <div class="clearfix"></div>
                        <div class="pagination paginacion-blog col-12">
                            <div class="pull-right">
                                {{$posts->links('pagination::bootstrap-4')}}
                            </div>
                        </div>
                @else
                <div class=" col-12">
                    <div class="white-box">
                            <h2 class="text-center">404 Post no encontrado</h2>
                        <hr>
                        <p class="text-center">No hemos podido encontrar el Contenido que está buscando.</p>
                    </div>
                </div>
            @endif
            </div>               
        </div>
    </div>    
</div>
@stop
