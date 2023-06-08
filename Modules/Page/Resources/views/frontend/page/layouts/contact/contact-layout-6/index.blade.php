<div class="page page-{{$page->id}} page-contact page-contact-layout-6" id="pageContactLayout6">
  <div class="page-content-contact mb-5">
    <div class="content pb-2">
      <div class="container">
        <div id="breadcrumbSection">
          @include('page::frontend.partials.breadcrumb')
        </div>
        <div class="col-12 py-3">
          <h1 class="text-uppercase text-center title-page">
            {{$page->title}}
          </h1>
          <div class="content-text">
            {!! $page->body !!}
          </div>
        </div>
      </div>
      <div class="content-banner-form">
        <div class="content-bg-image">
          <x-media::single-image imgClasses="bg-banner-form" :mediaFiles="$page->mediaFiles()" :isMedia="true"
                                 :alt="$page->title" zone="breadcrumbimage"/>
        </div>
        <div class="container py-5">
          <div class="row">
            <div class="col-12 col-md-6 m-auto pb-5">
              @if(isset($page) &&
                        empty($page->mainimage) &&
                        (strpos($page->mediafiles()->mainimage->extraLargeThumb, 'default.jpg')) == false)
                <x-media::single-image :mediaFiles="$page->mediaFiles()" imgClasses="image-page" :isMedia="true"
                                       :alt="$page->title" zone="mainimage"/>
              @endif
            </div>
            <div class="col-12 col-md-6 m-auto">
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
              <x-iforms::form id="{{$form->id}}"/>
            </div>
          </div>
        </div>
      </div>
      <div class="info-contact container pt-5">
        <x-isite::contact.addresses/>
        <x-isite::contact.phones/>
        <x-isite::contact.emails/>
      </div>
    </div>
  </div>
</div>

<style>
    @media (min-width: 768px) {
        .page-content-contact .content-text h2 {
            font-size: 25px !important;
        }
        .page-content-contact .content-text p, .page-content-contact .content-text span {
            font-size: 19px !important;
        }
    }
    .page-content-contact .content-banner-form {
        position: relative;
    }
    .page-content-contact .content-banner-form .content-bg-image {
        position: absolute;
        height: 100%;
        padding: 20px 0;
        width: 100%;
    }
    .page-content-contact .content-banner-form .content-bg-image:after {
        content: " ";
        line-height: 0;
        height: 94.2%;
        width: 100%;
        position: absolute;
        left: 0;
        top: 21px;
        visibility: initial;
        background: linear-gradient(269deg, rgba(0, 0, 0, 0.75) 100%, rgba(181, 181, 181, 0.27) 68%);
    }
    @media (min-width: 768px) {
        .page-content-contact .content-banner-form .content-bg-image {
            padding: 0;
        }
        .page-content-contact .content-banner-form .content-bg-image:after {
            height: 100%;
            top: 0;
        }
    }
    .page-content-contact .content-banner-form .bg-banner-form {
        height: 100%;
    }
    .page-content-contact form .form-group label {
        display: none;
    }
    .page-content-contact form .form-group .form-control {
        background: transparent;
        border-radius: 23px;
        padding-left: 26px;
        color: white;
    }
    .page-content-contact form .form-group .form-control::placeholder {
        color: white;
    }
    .page-content-contact form .form-group input {
        height: 50px;
        line-height: 50px;
    }
    .page-content-contact form .form-group .col-sm-12.text-right {
        text-align: left !important;
    }
    .page-content-contact form .form-group button {
        height: 40px;
        width: 116px;
        padding: 0;
        text-align: center;
        line-height: 40px;
        border-radius: 25px;
    }
    .page-content-contact #CheckFormTermsAndConditions label {
        font-size: 18px;
        color: white;
        margin-bottom: 15px;
    }
    .page-content-contact #CheckFormTermsAndConditions label a {
        font-size: 18px;
    }
    .page-content-contact .content-contact i {
        color: var(--primary);
        font-size: 19px;
    }
    .page-content-contact .content-contact a, .page-content-contact .content-contact p, .page-content-contact .content-contact div {
        color: #444;
        font-size: 16px;
    }

</style>