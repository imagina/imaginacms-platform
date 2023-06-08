<div class="page page-{{$page->id}} page-our page-our-layout-4" id="pageOurLayout4">
  <div class="page-banner banner-breadcrumb-category position-relative">
    <div class="position-absolute h-100 w-100 content-title">
      <div class="container d-flex flex-column align-items-center w-100 h-100 justify-content-center">
        <h1 class="title-page">
          {{$page->title}}
        </h1>
        @include('page::frontend.partials.breadcrumb')
      </div>
    </div>
    <div class="content-title-hidden"></div>
    @if (isset($page) && !empty($page->mediafiles()->breadcrumbimage) && strpos($page->mediaFiles()->breadcrumbimage->extraLargeThumb, 'default.jpg') == false)
      <x-media::single-image :title="$page->title" :isMedia="true" width="100%" :mediaFiles="$page->mediaFiles()"
                             zone="breadcrumbimage"/>
    @else
      <div class="pb-5 pt-5" style="background-color: var(--primary)"></div>
    @endif
  </div>
  <div class="content-page pt-5">
    <div class="container">
      <div class="row justify-content-center">
        <div class="content-image-main col-10">
          @if (isset($page) && !empty($page->mediafiles()->mainimage) && strpos($page->mediaFiles()->mainimage->extraLargeThumb, 'default.jpg') == false)
            <x-media::single-image :title="$page->title" :isMedia="true" width="100%" :mediaFiles="$page->mediaFiles()"
                                   zone="mainimage"/>
          @endif
        </div>
        <div class="content-description col-12">
          <div class="description-page pt-5">
            {!! $page->body !!}
          </div>
        </div>
      </div>
    </div>
    @if(count($page->mediaFiles()->gallery) > 0)
      <div class="gallery-section py-3">
        <x-media::gallery :mediaFiles="$page->mediaFiles()"
                          :responsive="[0 => ['items' => 1], 640 => ['items' => 2], 992 => ['items' => 5]]"/>
      </div>
    @endif
  </div>
</div>
