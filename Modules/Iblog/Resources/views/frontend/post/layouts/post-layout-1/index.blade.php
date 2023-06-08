@extends('layouts.master')

@section('meta')
  @include('iblog::frontend.partials.post.metas')
@stop

@section('title')
  {{ $post->title }} | @parent
@stop

@section('content')
  <div id="postLayout1" class="post-layout-1 page blog single single-{{$category->slug}} single-{{$category->id}}">
    <div class="page-banner position-relative">
      @if (isset($category))
        <div class="position-absolute h-100 w-100 content-title">
          <div class="container d-flex flex-column align-items-center w-100 h-100 justify-content-center">
            <div class="content-breadcrumb-center">
              <h1 class="h2 text-white text-center">
                {{$category->title}}
              </h1>
              @include('iblog::frontend.partials.breadcrumb')
            </div>
          </div>
        </div>
        <div class="content-title-hidden"></div>
        @if (isset($category) && empty($category->breadcrumb) && strpos($category->mediaFiles()->breadcrumbimage->extraLargeThumb, 'default.jpg') == false)
          <div class="content-image h-100">
            <x-media::single-image
              :title="$category->title"
              :isMedia="true"
              width="100%"
              :mediaFiles="$category->mediaFiles()"
              zone="breadcrumbimage"
            />
          </div>
        @elseif (isset($post) && empty($post->breadcrumb) && strpos($post->mediaFiles()->breadcrumbimage->extraLargeThumb, 'default.jpg') == false)
          <div class="content-image h-100">
            <x-media::single-image
              :title="$post->title"
              :isMedia="true"
              width="100%"
              :mediaFiles="$post->mediaFiles()"
              zone="breadcrumbimage"
            />
          </div>
        @endif
      @endif
    </div>
    <div class="post-content container py-5">
      @if(isset($post->mediaFiles()->mainimage)&&!empty($post->mediaFiles()->mainimage))
        <div class="col-12 col-md-10 m-auto">
          <x-media::single-image imgClasses=""
                                 :mediaFiles="$post->mediaFiles()"
                                 :isMedia="true" :alt="$post->title"/>
        </div>
      @endif
      <div class="col-12 post-description pt-3">
        <div class="section-title pb-5 d-flex justify-content-center">
          <h1 class="title text-primary">{{ $post->title }}</h1>
        </div>
        <div class="post-description text-justify">
          {!! $post->description !!}
        <div class="blog-related col-12 pb-5">
          <h4 class="text-center h5 font-weight-bold">{{trans('iblog::common.layouts.titleRelatedPosts')}}</h4>
          <x-isite::carousel.owl-carousel
          id="Articles"
          repository="Modules\Iblog\Repositories\PostRepository"
          :params="['take' => 20,'filter' => ['category' => $category->id,'exclude'=>$post->id]]"
          :margin="25"
          :loops="false"
          :dots="false"
          :navText="['<i class=\'fa fa-chevron-left\'></i>','<i class=\'fa fa fa-chevron-right\'></i>']"
          mediaImage="mainimage"
          :autoplay="false"
          :responsive="[300 => ['items' =>  1],700 => ['items' =>  2], 1024 => ['items' => 3]]"
          :itemComponentAttributes="config('asgard.iblog.config.itemComponentAttributesBlog')"
        />
        </div>
      </div>
    </div>
  </div>
@stop