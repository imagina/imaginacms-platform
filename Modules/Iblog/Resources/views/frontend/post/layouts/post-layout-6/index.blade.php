@extends('layouts.master')

@section('meta')
  @include('iblog::frontend.partials.post.metas')
@stop

@section('title')
  {{ $post->title }} | @parent
@stop

@section('content')
  <div id="layoutPost6" class="page page-{{$post->id}} pages-internal">
    <div class="page-banner position-relative">
      @if (isset($category))
        <div class="position-absolute h-100 w-100 content-title">
          <div class="container d-flex flex-column align-items-center w-100 h-100 justify-content-center">
            <div class="content-breadcrumb-center">
              <h1 class="text-white text-center h2">
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
    <div class="content">
      <div class="container">
        <div class="row justify-content-center">
          @if(isset($post->mediaFiles()->mainimage)&&!empty($post->mediaFiles()->mainimage))
            <div class="col-8">
              <x-media::single-image :mediaFiles="$post->mediaFiles()"
                                     imgClasses="image-internal"
                                     :isMedia="true"
                                     :alt="$post->title"
                                     zone="mainimage"/>
            </div>
          @endif
          <div class="col-12">
            <div class="info-section py-3">
              <div class="title-page h1 d-flex justify-content-center py-3">
                {{ $post->title }}
              </div>
              {!! $post->description !!}
            </div>
            <div class="mb-5">
              {{--          trans('iblog::common.layouts.posts.layout6.titleCarousel')--}}
              <div class="mt-2 mb-3 title-carousel-page h1 text-primary d-flex">
                {{trans('iblog::common.layouts.posts.layout6.titleCarousel')}}
              </div>
              <x-isite::carousel.owl-carousel
                id="Articles"
                repository="Modules\Iblog\Repositories\PostRepository"
                :params="['take' => 20,'filter' => ['category' => $category->id,'exclude'=>$post->id]]"
                :margin="25"
                :loops="false"
                :dots="false"
                mediaImage="mainimage"
                :autoplay="false"
                :responsive="[300 => ['items' =>  1],700 => ['items' =>  2], 1024 => ['items' => 3]]"
                :itemComponentAttributes="config('asgard.iblog.config.itemComponentAttributesBlog')"
              />
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@stop

<style>
    #layoutPost6 .page-banner {
        height: 200px;
    }

    #layoutPost6 .page-banner .content-title {
        z-index: 8;
    }

    #layoutPost6 .page-banner .content-title-hidden {
        position: absolute;
        height: 100%;
        width: 100%;
        background-color: var(--primary);
        z-index: -1;
    }

    #layoutPost6 .page-banner .content-image:before {
        content: " ";
        /*background: #0a0a0a;*/
        position: absolute;
        left: 0;
        height: 100%;
        width: 100%;
    }

    #layoutPost6 .page-banner img {
        height: 100%;
        object-fit: cover;
        object-position: left;
    }

    #layoutPost6 .page-banner h1 {
        font-size: 36px;
    }

    #layoutPost6 .page-banner .page-breadcrumb .breadcrumb, #layoutPost6 .page-banner #breadcrumbSection .breadcrumb {
        margin-bottom: 0 !important;
    }

    #layoutPost6 .page-banner .page-breadcrumb .breadcrumb .breadcrumb-item::before, #layoutPost6 .page-banner #breadcrumbSection .breadcrumb .breadcrumb-item::before {
        padding-right: 0;
    }

    #layoutPost6 .page-banner .page-breadcrumb .breadcrumb li:first-child:before, #layoutPost6 .page-banner #breadcrumbSection .breadcrumb li:first-child:before {
        display: none;
    }

    #layoutPost6 .page-banner .page-breadcrumb .breadcrumb li, #layoutPost6 .page-banner #breadcrumbSection .breadcrumb li {
        display: flex;
        align-items: center;
        font-size: 14px;
        color: #fff;
        padding: 0;
    }

    #layoutPost6 .page-banner .page-breadcrumb .breadcrumb li:before, #layoutPost6 .page-banner #breadcrumbSection .breadcrumb li:before {
        margin: 0 4px;
        color: #fff;
    }

    #layoutPost6 .page-banner .page-breadcrumb .breadcrumb a, #layoutPost6 .page-banner #breadcrumbSection .breadcrumb a {
        font-size: 14px;
        color: #fff;
    }

    #layoutPost6 .page-banner.banner-breadcrumb-category div.content-breadcrumb-top ol.breadcrumb {
        margin-bottom: 0 !important;
        margin-top: 10px;
    }

    #layoutPost6 .page-banner.banner-breadcrumb-category div.content-breadcrumb-top ol.breadcrumb li {
        color: #656d72 !important;
    }

    #layoutPost6 .page-banner.banner-breadcrumb-category div.content-breadcrumb-top ol.breadcrumb li:before {
        color: #656d72 !important;
    }

    #layoutPost6 .page-banner.banner-breadcrumb-category div.content-breadcrumb-top ol.breadcrumb a {
        color: #656d72 !important;
        font-weight: bolder;
    }

    @media (max-width: 767.98px) {
        #layoutPost6 .page-banner.banner-breadcrumb-category div.content-breadcrumb-top {
            display: none !important;
        }
    }

    #layoutPost6 .page-banner.banner-breadcrumb-category h1 {
        color: #fff !important;
    }

    #layoutPost6 .page-banner.banner-breadcrumb-category div.content-breadcrumb-center ol.breadcrumb li {
        color: var(--primary) !important;
    }

    #layoutPost6 .page-banner.banner-breadcrumb-category div.content-breadcrumb-center ol.breadcrumb li:before {
        color: var(--primary) !important;
    }

    #layoutPost6 .page-banner.banner-breadcrumb-category div.content-breadcrumb-center ol.breadcrumb a {
        color: var(--primary) !important;
        font-weight: bolder;
    }

    #layoutPost6.pages-internal .image-internal {
        position: relative;
        top: -57px;
        margin-bottom: -57px;
    }

    #layoutPost6.pages-internal .info-section .title-page {
        position: relative;
        font-weight: bold;
        font-size: 45px;
    }

    #layoutPost6.pages-internal .info-section .title-page:before {
        background: var(--secondary);
        content: " ";
        width: 50px;
        height: 5px;
        position: absolute;
        left: 0;
        right: 0;
        bottom: 11px;
        margin: auto;
    }

    #layoutPost6.pages-internal .info-section h2 {
        color: var(--primary);
    }

    #layoutPost6.pages-internal .title-carousel-page {
        position: relative;
        font-weight: bold;
        font-size: 45px;
    }

</style>