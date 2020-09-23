@extends('layouts.master')

@section('meta')
    @include('iblog::frontend.partials.post.metas')
@stop

@section('title')
    {{ $post->title }} | @parent
@stop

@section('content')


<div class="page blog single single-{{$category->slug}} single-{{$category->id}} pb-5">
     @component('partials.widgets.breadcrumb')
     @if($category->parent)
                    <li class="breadcrumb-item" aria-current="page"><a href="{{url($category->parent->slug)}}">{{$category->parent->title}}</a></li>
    @endif
                    <li class="breadcrumb-item" aria-current="page"><a href="{{url($category->slug)}}">{{$category->title}}</a></li>
                     <li class="breadcrumb-item active" aria-current="page"> {{$post->title}}</li>
                  @endcomponent
    <div class="container" id="body-wrapper">
        <div class="row">   
                <div class="col-12">    
                         <h1 >{{ $post->title }}</h1>
                </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-6">
                <a href="{{$post->mainimage->path}}" data-fancybox="gallery">
                    <img src="{{$post->mainimage->path}}" alt="Gallery Image">
                </a>
            </div>
                       
            <div class="content col-12 col-md-6 ">
               
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
        </div>
    </div>
</div>


@stop

@section('scripts')
    @parent
    @include('iblog::frontend.partials.post.script')
@stop