<div class="page page-{{$page->id}} page-our page-our-layout-1" id="pageOurLayout1">
  <div class="page-banner banner-breadcrumb-category position-relative">
    <div class="position-absolute h-100 w-100 content-title">
      <div class="container d-flex flex-column align-items-center w-100 h-100 justify-content-center">
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
  @if (isset($page) && count($page->mediaFiles()->gallery) > 0 || !empty($page->mediafiles()->mainimage) &&
          (strpos($page->mediafiles()->mainimage->extraLargeThumb, 'default.jpg')) == false)
    <div>
      <div class="container col-md-8 m-auto our-section" id="cardOur">
        <div class="card">
          @if (isset($page) && count($page->mediaFiles()->gallery) > 0)
            <x-media::gallery :mediaFiles="$page->mediaFiles()"
                              :responsive="[0 => ['items' => 1]]"
                              :dots="true" :nav="true"
                              :navText="['<i class=\'fa fa-chevron-left\'></i>', '<i class=\'fa fa-chevron-right\'></i>']"
            />
          @else
            <x-media::single-image :title="$page->title" :isMedia="true" width="100%" :mediaFiles="$page->mediaFiles()"
                                   zone="mainimage"/>
          @endif
        </div>
      </div>
    </div>
  @endif
  <div class="content-page py-3">
    <div class="container">
      <h1 class="text-primary text-center text-uppercase title-page">
        {{$page->title}}
      </h1>
      {!! $page->body !!}
    </div>
  </div>
</div>

<style>
    #pageOurLayout1 .breadcrumb {
        justify-content: center;
        margin-bottom: 27px !important;
    }

    #pageOurLayout1 .breadcrumb .breadcrumb-item {
        font-size: 18px;
        color: #fff !important;
        font-weight: 100;
        text-transform: uppercase;
    }

    #pageOurLayout1 .breadcrumb .breadcrumb-item a {
        color: #fff !important;
    }

    @media (max-width: 991.98px) {
        #pageOurLayout1 .content-title h1 {
            font-size: 25px;
        }

        #pageOurLayout1 .content-title #breadcrumbSection ol.breadcrumb li.breadcrumb-item {
            color: #fff !important;
            font-size: 14px;
        }

        #pageOurLayout1 .content-title #breadcrumbSection ol.breadcrumb li.breadcrumb-item:before {
            color: #fff !important;
        }

        #pageOurLayout1 .content-title #breadcrumbSection ol.breadcrumb li.breadcrumb-item a {
            color: #fff !important;
            font-size: 14px;
        }
    }

    #cardOur {
        position: relative;
        top: -3vw;
    }

    #cardOur .card {
        border-radius: 20px;
        box-shadow: 1px 2px 10px 4px #020202 1 f;
    }

    #cardOur .card .card-body {
        padding: 4.5vw;
    }

    @media (max-width: 991.98px) {
        #cardOur .card-title {
            text-align: center;
            font-size: 22px;
        }

        #cardOur .card-title:after {
            margin: auto !important;
        }

        #cardOur .btn {
            width: 80px;
            font-size: 15px !important;
        }

        #cardOur .contact-section {
            font-size: 15px;
        }

        #cardOur .fa-phone, #cardContact .fa-map-marker, #cardContact .fa-envelope {
            font-size: 15px;
        }

        #cardOur #componentContactAddresses:before, #cardContact #componentContactPhones:before, #cardContact #componentContactEmails:before {
            padding-left: 1.8rem;
        }

        #cardOur #socialIn {
            text-align: center;
        }
    }

    @media (max-width: 767.98px) {
        #cardOur {
            top: -56vw;
        }
    }
</style>