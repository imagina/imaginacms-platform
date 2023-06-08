<div class="page-{{ $page->id }}" id="contactSection">
  <div class="page-banner banner-breadcrumb-category position-relative page-contact">
    <div class="position-absolute h-100 w-100 content-title">
      <div class="container d-flex flex-column align-items-center w-100 h-100 justify-content-center">
        <h1 class="title-page text-primary">
          {{$page->title}}
        </h1>
        @include('page::frontend.partials.breadcrumb')
      </div>
    </div>
    <div class="content-title-hidden"></div>
    @if (isset($page) && !empty($page->mediafiles()->mainimage) && strpos($page->mediaFiles()->breadcrumbimage->extraLargeThumb, 'default.jpg') == false)
      <x-media::single-image :title="$page->title" :isMedia="true" width="100%" :mediaFiles="$page->mediaFiles()"
                             zone="breadcrumbimage"/>
    @else
      <div class="pb-5 pt-5" style="background-color: var(--primary)"></div>
    @endif
  </div>
  @if (isset($page) && count($page->mediaFiles()->gallery) > 0 || !empty($page->mediafiles()->mainimage) &&
          (strpos($page->mediafiles()->mainimage->extraLargeThumb, 'default.jpg')) == false)
    <div style="background: #e6e6e6">
      <div class="container contact-section pt-5 pb-5" id="cardOur">
        <div class="card">
          @if (isset($page) && count($page->mediaFiles()->gallery) > 0)
            <x-media::gallery :mediaFiles="$page->mediaFiles()"
                              :responsive="[0 => ['items' => 1]]"
                              :dots="true" :nav="true"
                              :navText="['<i class=\'fa fa-chevron-left\'></i>', '<i class=\'fa fa-chevron-right\'></i>']"
            />
          @else
            <x-media::single-image :title="$page->title" :isMedia="true" width="100%" :mediaFiles="$page->mediaFiles()"
                                   zone="breadcrumbimage"/>
          @endif
        </div>
      </div>
    </div>
  @endif
  <div class="content-page py-3">
    <div class="container">
      {!! $page->body !!}
    </div>
    @if(count($page->mediaFiles()->gallery) > 0)
      <div class="gallery-section py-3">
        <x-media::gallery :mediaFiles="$page->mediaFiles()"
                          :responsive="[0 => ['items' => 1], 640 => ['items' => 2], 992 => ['items' => 5]]"/>
      </div>
    @endif
  </div>
</div>