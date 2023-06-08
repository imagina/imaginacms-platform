<div class="page page-{{$page->id}} page-our page-our-layout-6" id="pageOurLayout6">
  <div class="position-absolute h-100 w-100 content-title d-flex align-items-center">
    <div class="container">
      <h1 class="text-white text-uppercase">
        {{ $page->title }}
      </h1>
    </div>
  </div>
  <div class="content-title-hidden"></div>
  @if (isset($page) && !empty($page->mediafiles()->breadcrumbimage) && strpos($page->mediaFiles()->breadcrumbimage->extraLargeThumb, 'default.jpg') == false)
    <x-media::single-image :title="$page->title" :isMedia="true" width="100%" :mediaFiles="$page->mediaFiles()"
                           zone="breadcrumbimage"
    />
  @else
    <div class="page-banner"></div>
  @endif
  <div class="container pb-5">
    <div class="content-breadcrumb-center">
      <div id="breadcrumbSection" class="py-2">
        @include('page::frontend.partials.breadcrumb')
      </div>
    </div>
    <div class="row justify-content-between">
      @if (isset($page) && !empty($page->mediafiles()->mainimage) && strpos($page->mediaFiles()->mainimage->extraLargeThumb, 'default.jpg') == false)
        <div class="col-md-6">
          <x-media::single-image
            :title="$page->title"
            :isMedia="true" width="100%"
            :mediaFiles="$page->mediaFiles()"
            zone="mainimage"
            imgClasses="image-rounded"
          />
        </div>
      @endif
      <div
        class="@if (isset($page) && !empty($page->mediafiles()->mainimage) &&
                strpos($page->mediaFiles()->mainimage->extraLargeThumb, 'default.jpg') == false)
          col-md-6 @else col-md-12 @endif">
        {!! $page->body !!}
      </div>
    </div>
  </div>
</div>
