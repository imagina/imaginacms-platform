<div class="page page-{{$page->id}} page-contact page-contact-layout-5" id="pageContactLayout5">
  <div id="breadcrumbSection">
    @include('page::frontend.partials.breadcrumb')
  </div>
  <div class="container contact-section" id="cardContact">
    <div class="col-12">
      <h1 class="title-contact-main text-uppercase pt-2 pt-md-4 pb-2 pb-md-5 title-page">
        {{ $page->title }}
      </h1>
    </div>
    <div class="content-form">
      <div class="card-body">
        <div class="row justify-content-between">
          <div class="col-auto col-sm-12 col-md-12 col-lg-5 data-contact">
            <div class="row">
              <div class="col-12 pb-4">
                <h5
                  class="title-contact-secondary">{{trans('page::common.layouts.layoutContact.layout5.titleContactSecondary')}}</h5>
              </div>
              <div class="col-12">
                <div class="contact-section pt-3">
                  @if(json_decode(setting('isite::phones')) != [])
                    <div class="row border-bottom pb-4 mb-4">
                      <div class="col-12 col-md-1 col-lg-2">
                        <i class="fa fa-phone"></i>
                      </div>
                      <div class="col-10">
                        <div class="title-contact">
                          {{trans('page::common.layouts.layoutContact.layout5.titleContactPhone')}}
                        </div>
                        <x-isite::contact.phones :showIcon="false"/>
                      </div>
                    </div>
                  @endif
                  @if(json_decode(setting('isite::addresses')) != [])
                    <div class="row border-bottom pb-4 mb-4">
                      <div class="col-12 col-md-1 col-lg-2">
                        <i class="fa fa-map-marker"></i>
                      </div>
                      <div class="col-10">
                        <div class="title-contact">
                          {{trans('page::common.layouts.layoutContact.layout5.titleContactAddress')}}
                        </div>
                        <x-isite::contact.addresses :showIcon="false"/>
                      </div>
                    </div>
                  @endif
                  @if(json_decode(setting('isite::emails')) != [])
                    <div class="row border-bottom pb-4 mb-4">
                      <div class="col-12 col-md-1 col-lg-2">
                        <i class="fa fa-envelope"></i>
                      </div>
                      <div class="col-10">
                        <div class="title-contact">
                          {{trans('page::common.layouts.layoutContact.layout5.titleContactEmail')}}
                        </div>
                        <x-isite::contact.emails :showIcon="false"/>
                      </div>
                    </div>
                  @endif
                </div>
              </div>
            </div>
          </div>
          <div class="col-auto col-sm-12 col-md-12 col-lg-6 send-msg">
            <div class="">{!! $page->body !!}</div>
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
  </div>
</div>
<div class="container-fluid px-0" id="sectionMaps">
  <div class="container border-top">
    <div id="socialNetworkSection" class="social-contact">
      <x-isite::social :withWhatsapp="false"/>
    </div>
  </div>
  @php
    $location = json_decode(setting('isite::locationSite'));
    $mapLat = (string)$location->lat;
    $mapLng = (string)$location->lng;
  @endphp
  @if($mapLat != (string)4.6469204494764 || $mapLng != (string)-74.078579772573)
    <div class="widget-map">
      <x-isite::Maps/>
    </div>
  @endif
</div>

<style>
    #cardContact .title-contact-main {
        font-size: 38px;
        color: var(--secondary);
        font-weight: bold;
    }

    #cardContact .content-form .card-body .card-title {
        font-weight: 300;
        color: var(--secondary);
        font-size: 28px;
    }

    #cardContact .content-form .card-body .send-msg label {
        display: none;
    }

    #cardContact .content-form .card-body .send-msg #CheckFormTermsAndConditions label {
        display: block;
    }

    #cardContact .content-form .card-body .send-msg .card-title:after {
        content: "";
        display: block;
        border-bottom: 3px solid var(--primary);
        width: 70px;
    }

    #cardContact .content-form .card-body .send-msg input {
        border: none !important;
        border-bottom: 1px solid #c9c9c9 !important;
        border-radius: 0 !important;
        padding: 37px 10px;
    }

    #cardContact .content-form .card-body .send-msg .btn {
        color: #fff;
        font-size: 18px !important;
        font-weight: bold;
        background: var(--primary);
        border-color: transparent;
        border-radius: 20px;
        width: 100px;
        float: left;
    }

    #cardContact .content-form .card-body #hrVertical {
        height: 500px;
        border-left: 1px solid #c9c9c9;
    }

    #cardContact .content-form .card-body .data-contact .card-title:after {
        content: "";
        display: block;
        border-bottom: 3px solid var(--primary);
        width: 54px;
    }

    #cardContact .content-form .card-body .data-contact .title-contact-secondary {
        font-size: 24px;
        color: var(--primary);
        font-weight: bold;
    }

    #cardContact .content-form .card-body .data-contact .contact-section {
        font-size: 18px;
    }

    #cardContact .content-form .card-body .data-contact .contact-section .fa-phone,
    #cardContact .content-form .card-body .data-contact .contact-section .fa-map-marker,
    #cardContact .content-form .card-body .data-contact .contact-section .fa-envelope {
        color: var(--primary);
        font-size: 28px;
    }

    #cardContact .content-form .card-body .data-contact .contact-section .title-contact {
        font-size: 22px;
        color: var(--primary);
        font-weight: bold;
    }

    #cardContact .content-form .card-body .data-contact .contact-section #componentContactAddresses a,
    #cardContact .content-form .card-body .data-contact .contact-section #componentContactPhones a,
    #cardContact .content-form .card-body .data-contact .contact-section #componentContactEmails a {
        color: #020202;
    }

    #cardContact .content-form .card-body .data-contact .contact-section #componentContactEmails a:before {
        color: var(--secondary);
        font-weight: bold;
        padding-left: 2.3rem;
    }

    #cardContact .content-form .card-body #socialIn a i {
        display: inline-flex;
        width: 40px;
        height: 20px;
        margin: 5px;
        align-items: center;
        justify-content: center;
        transition: 0.2s;
        color: var(--primary) !important;
        font-size: 1.25rem;
    }

    #cardContact .content-form .card-body #socialIn a i .fa-youtube:before {
        content: "\f16a";
        font-family: 'FontAwesome';
    }


    @media (max-width: 991.98px) {
        #cardContact .card-title {
            text-align: center;
            font-size: 22px;
        }

        #cardContact .card-title:after {
            margin: auto !important;
        }

        #cardContact .btn {
            width: 80px;
            font-size: 15px !important;
        }

        #cardContact .contact-section {
            font-size: 15px;
        }

        #cardContact .fa-phone,
        #cardContact .fa-map-marker,
        #cardContact .fa-envelope {
            font-size: 15px;
        }

        #cardContact #componentContactAddresses:before,
        #cardContact #componentContactPhones:before,
        #cardContact #componentContactEmails:before {
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

    .social-contact {
        height: 100px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .social-contact a {
        height: 43px;
        width: 43px;
        border: 1px solid var(--primary);
        border-radius: 50%;
        display: inline-flex;
        justify-content: center;
        align-items: center;
        margin: 0 1vw;
    }
</style>