<div class="page page-{{$page->id}} page-contact page-contact-layout-4" id="pageContactLayout4">
  <div class="page-banner banner-breadcrumb-category position-relative page-contact">
    <div class="position-absolute h-100 w-100 content-title">
      <div class="container d-flex flex-column align-items-center w-100 h-100 justify-content-center">
        <h1 class="text-white text-center al-center title-page">
          {{ $page->title }}
        </h1>
        @include('page::frontend.partials.breadcrumb')
      </div>
    </div>
    <div class="content-title-hidden"></div>
    @if (isset($page) && empty($page->breadcrumb) && strpos($page->mediaFiles()->breadcrumbimage->extraLargeThumb, 'default.jpg') == false)
      <x-media::single-image :title="$page->title" :isMedia="true" width="100%" :mediaFiles="$page->mediaFiles()"
                             zone="breadcrumbimage"/>
    @else
      <div class="pb-5 pt-5" style="background-color: var(--primary)"></div>
    @endif
  </div>
  <div style="background: #e6e6e6">
    <div class="container contact-section pt-5 pb-5" id="cardContact">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-auto col-sm-12 col-md-12 col-lg-6 send-msg">
              <h5 class="card-title">
                {{trans('page::common.layouts.layoutContact.layout4.titleFormPageContact')}}
              </h5>
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
            <hr id="hrVertical" class="d-none d-lg-block">
            <div class="col-auto col-sm-12 col-md-12 col-lg-5 data-contact">
              <div class="row">
                <div class="page-description col-12">
                  {!! $page->body !!}
                </div>
                <div class="col-12">
                  <h5
                    class="card-title">{{trans('page::common.layouts.layoutContact.layout4.titleInfoPageContact')}}</h5>
                </div>
                <div class="col-12">
                  <div class="contact-section pt-3">
                    @if(json_decode(setting('isite::addresses')) != [])
                      <div class="title-contact mt-2 mb-1">
                        <i class="fa fa-map-marker"></i>
                        <div class="d-inline-block font-weight-bold pl-3">
                          {{trans('page::common.layouts.layoutContact.layout4.titleAddressPageContact')}}
                        </div>
                      </div>
                      <x-isite::contact.addresses classes="ml-3"/>
                    @endif
                    @if(json_decode(setting('isite::phones')) != [])
                      <div class="title-contact mt-2 mb-1">
                        <i class="fa fa-phone"></i>
                        <div class="d-inline-block font-weight-bold pl-3">
                          {{trans('page::common.layouts.layoutContact.layout4.titlePhonePageContact')}}
                        </div>
                      </div>
                      <x-isite::contact.phones classes="ml-3"/>
                    @endif
                    @if(json_decode(setting('isite::emails')) != [])
                      <div class="title-contact mt-2 mb-1">
                        <i class="fa fa-envelope"></i>
                        <div class="d-inline-block font-weight-bold pl-3">
                          {{trans('page::common.layouts.layoutContact.layout4.titleEmailPageContact')}}
                        </div>
                      </div>
                      <x-isite::contact.emails classes="ml-3"/>
                    @endif
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-12">
                  <h5
                    class="card-title text-bold pt-4">{{trans('page::common.layouts.layoutContact.layout4.titleSocialPageContact')}}</h5>
                </div>
                <div class="col-12">
                  <div id="socialIn">
                    <x-isite::social/>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  @php
    $location = json_decode(setting('isite::locationSite'));
    $mapLat = (string)$location->lat;
    $mapLng = (string)$location->lng;
  @endphp
  @if($mapLat != (string)4.6469204494764 || $mapLng != (string)-74.078579772573)
    <div class="container-fluid px-0" id="sectionMaps">
      <div class="justify-content-center">
        <div class="text-center">
          <i class="fa fa-map-marker" aria-hidden="true"></i>
          <h5 class="title">
            {{trans('page::common.layouts.layoutContact.layout4.titleMapPageContact')}}
          </h5>
        </div>
      </div>
      <div class="widget-map">
        <x-isite::Maps/>
      </div>
    </div>
  @endif
</div>

<style>
    #contactSection .breadcrumb {
        justify-content: center;
        margin-bottom: 27px;
    }

    #contactSection .breadcrumb .breadcrumb-item {
        font-size: 18px;
        color: #fff;
        font-weight: 100;
        text-transform: uppercase;
    }

    #contactSection .breadcrumb .breadcrumb-item a {
        color: #fff;
    }

    @media (max-width: 991.98px) {
        #contactSection .content-title h1 {
            font-size: 25px;
        }

        #contactSection .content-title #breadcrumbSection ol.breadcrumb li.breadcrumb-item {
            color: #fff;
            font-size: 14px;
        }

        #contactSection .content-title #breadcrumbSection ol.breadcrumb li.breadcrumb-item:before {
            color: #fff;
        }

        #contactSection .content-title #breadcrumbSection ol.breadcrumb li.breadcrumb-item a {
            color: #fff;
            font-size: 14px;
        }
    }

    #cardContact {
        position: relative;
        top: -8vw;
    }

    #cardContact .card {
        border-radius: 20px;
        box-shadow: 1px 2px 10px 4px #020202 1 f;
    }

    #cardContact .card .card-body {
        padding: 4.5vw;
    }

    #cardContact .card .card-body .card-title {
        font-weight: 700;
        color: var(--secondary);
        font-size: 28px;
    }

    #cardContact .card .card-body .send-msg label {
        display: none;
    }

    #cardContact .card .card-body .send-msg .card-title:after {
        content: "";
        display: block;
        border-bottom: 3px solid var(--primary);
        width: 70px;
    }

    #cardContact .card .card-body .send-msg input {
        border: none;
        border-bottom: 1px solid #c9c9c9;
        border-radius: 0;
        padding: 37px 10px;
    }

    #cardContact .card .card-body .send-msg .btn {
        color: #fff;
        font-size: 18px;
        font-weight: bold;
        background: var(--primary);
        border-color: transparent;
        border-radius: 20px;
        width: 100px;
        float: left;
    }

    #cardContact .card .card-body #hrVertical {
        height: 500px;
        border-left: 1px solid #c9c9c9;
    }

    #cardContact .card .card-body .data-contact .card-title:after {
        content: "";
        display: block;
        border-bottom: 3px solid var(--primary);
        width: 54px;
    }

    #cardContact .card .card-body .data-contact .contact-section {
        font-size: 18px;
    }

    #cardContact .card .card-body .data-contact .contact-section .fa-phone, #cardContact .card .card-body .data-contact .contact-section .fa-map-marker, #cardContact .card .card-body .data-contact .contact-section .fa-envelope {
        color: var(--primary);
        font-size: 28px;
        width: 28px;
    }

    #cardContact .card .card-body .data-contact .contact-section #componentContactAddresses a, #cardContact .card .card-body .data-contact .contact-section #componentContactPhones a, #cardContact .card .card-body .data-contact .contact-section #componentContactEmails a {
        color: var(--secondary);
    }

    #cardContact .card .card-body .data-contact .contact-section #componentContactAddresses i, #cardContact .card .card-body .data-contact .contact-section #componentContactPhones i, #cardContact .card .card-body .data-contact .contact-section #componentContactEmails i {
        visibility: hidden;
    }

    #cardContact .card .card-body .data-contact .contact-section #componentContactAddresses:before, #cardContact .card .card-body .data-contact .contact-section #componentContactPhones:before, #cardContact .card .card-body .data-contact .contact-section #componentContactEmails:before {
        color: var(--secondary);
        font-weight: bold;
        padding-left: 2.3rem;
    }

    #cardContact .card .card-body .data-contact .contact-section #componentContactAddresses:after, #cardContact .card .card-body .data-contact .contact-section #componentContactPhones:after, #cardContact .card .card-body .data-contact .contact-section #componentContactEmails:after {
        font-family: var(--fa-style-family, "Font Awesome 6 Pro");
        font-weight: var(--fa-style, 900);
        -moz-osx-font-smoothing: grayscale;
        -webkit-font-smoothing: antialiased;
        display: var(--fa-display, inline-block);
        font-style: normal;
        font-variant: normal;
        line-height: 1;
        text-rendering: auto;
        color: var(--primary);
        font-size: 1.75rem;
        position: absolute;
        top: 0;
    }

    #cardContact .card .card-body .data-contact .contact-section .content-phone {
        padding-left: 0.3rem;
    }

    #cardContact .card .card-body .data-contact .contact-section #componentContactPhones, #cardContact .card .card-body .data-contact .contact-section #componentContactEmails {
        padding-bottom: 0.5rem;
    }

    #cardContact .card .card-body .data-contact #socialIn a i {
        display: inline-flex;
        width: 40px;
        height: 20px;
        margin: 5px;
        align-items: center;
        justify-content: center;
        transition: 0.2s;
        color: var(--primary);
        font-size: 1.25rem;
    }

    #cardContact .card .card-body .data-contact #socialIn a i.fa-youtube:before {
        content: "\f16a";
        font-family: 'FontAwesome';
    }

    @media (max-width: 991.98px) {
        #cardContact .card-title {
            text-align: center;
            font-size: 22px;
        }

        #cardContact .card-title:after {
            margin: auto;
        }

        #cardContact .btn {
            width: 80px;
            font-size: 15px;
        }

        #cardContact .contact-section {
            font-size: 15px;
        }

        #cardContact .fa-phone, #cardContact .fa-map-marker, #cardContact .fa-envelope {
            font-size: 15px;
        }

        #cardContact #componentContactAddresses:before, #cardContact #componentContactPhones:before, #cardContact #componentContactEmails:before {
            padding-left: 1.8rem;
        }

        #cardContact #socialIn {
            text-align: center;
        }
    }

    @media (max-width: 767.98px) {
        #cardContact {
            top: -56vw;
        }
    }

    #sectionMaps {
        margin-top: -33vw;
        margin-bottom: -1rem;
    }

    #sectionMaps .fa-map-marker {
        color: var(--primary);
        width: 47px;
        height: 47px;
        border-radius: 50%;
        border: 2px solid var(--primary);
        font-size: 24px;
        display: flex;
        justify-content: center;
        align-items: center;
        margin: auto;
    }

    #sectionMaps .title {
        font-weight: 600;
        color: var(--secondary);
        font-size: 40px;
    }

    @media (max-width: 767.98px) {
        #sectionMaps {
            margin-top: -56vw;
        }
    }
</style>