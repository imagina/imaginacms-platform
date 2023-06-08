<div class="page page-{{$page->id}} page-gallery page-gallery-layout-1" id="pageGalleryLayout1">
  <div class="page-content py-3">
    <div class="container">
      <h1 class="text-primary text-center title-page">
        {{ $page->title }}
      </h1>
      <div class="page-description py-2 col-12">
        {!! $page->body !!}
      </div>
      <div class="row">
        <div class="col-md-12 py-3">
          <x-media::gallery :mediaFiles="$page->mediaFiles()" layout="gallery-layout-2" :columnMasonry="3"/>
        </div>
      </div>
    </div>
  </div>
</div>