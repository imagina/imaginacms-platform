<div class="page page-{{$page->id}} page-contact page-contact-layout-2" id="pageContactLayout2">
  <div class="top-banner position-relative">
    <div class="position-absolute h-100 w-100">
      <div class="container d-flex flex-column align-items-center w-100 h-100 justify-content-center">
        <h1 class="text-white text-uppercase title-page">
          {{$page->title}}
        </h1>
        @include('page::frontend.partials.breadcrumb')
      </div>
    </div>
    @if (isset($page) && empty($page->breadcrumb) && strpos($page->mediaFiles()->breadcrumbimage->extraLargeThumb, 'default.jpg') == false)
      <x-media::single-image :title="$page->title" :isMedia="true" width="100%" :mediaFiles="$page->mediaFiles()"
                             zone="breadcrumbimage"/>
    @else
      <img class="img-fluid w-100 h-100" src="{{ Theme::url('img/banner-page.jpg') }}" alt="img-{{$page->title}}">
    @endif
  </div>
  <div class="page-content">
    <div class="container pt-5 py-3 py-md-5">
      <div class="row">
        <div class="col-12">
          <div class="page-body mb-5">
            {!! $page->body !!}
          </div>
        </div>
        <div class="col-lg-6 mb-md-5">
          @php
            $formRepository = app("Modules\Iforms\Repositories\FormRepository");
            $params = [
                    "filter" => [
                      "field" => "system_name",
                    ],
                    "include" => [],
                    "fields" => [],
            ];
            $form = $formRepository->getItem("contact_form", json_decode(json_encode($params)));
          @endphp
          <div class="contact">
            <x-iforms::form id="{{$form->id}}"/>
          </div>
        </div>
        <div class="col-lg-6 mb-md-5">
          <figure>
            <x-media::single-image imgClasses="img-fluid w-100" :title="$page->title" :isMedia="true" width="100%"
                                   :mediaFiles="$page->mediaFiles()"
                                   zone="mainimage"/>
          </figure>
        </div>
      </div>
    </div>
  </div>
</div>