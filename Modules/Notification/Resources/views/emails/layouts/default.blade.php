<!DOCTYPE html>
<html lang="es" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
  <meta charset="utf-8">
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <meta name="x-apple-disable-message-reformatting">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <title></title>
  <style>
    table {
      border-collapse: collapse;
      border-spacing: 0;
      border: none;
      margin: 0;
    }

    div, td {
      padding: 0;
    }

    div {
      margin: 0 !important;
    }

    table, td, div, h1, p {
      font-family: 'Open Sans', sans-serif;
    }

    .w-60 {
      width: 60%;
    }

    .col-md-6 {
      display: inline-block;
      width: 50%;
      vertical-align: middle;
      font-family: Arial, sans-serif;
      font-size: 14px;
      color: #363636;
      margin-bottom: 12px;
    }

    .email-logo {
      width: 115px;
      height: 50px;
      object-fit: contain;
      object-position: left;
    }

    .email-title, #contend-mail h1 {
      margin-left: 10%;
      margin-right: 10%;
      margin-bottom: 16px;
      font-size: 22px;
      line-height: 26px;
      font-weight: 600;
      letter-spacing: -0.02em;
      color: #35364A;
    }

    .email-message {
      margin-left: 10%;
      margin-right: 10%;
      font-size: 18px;
      line-height: 20px;
      font-weight: 500;
      letter-spacing: -0.02em;
      color: #35364A;
      margin-top: 0;
      margin-bottom: 50px;
    }

    .email-date {
      margin-top: 0;
      margin-bottom: 0;
      text-align: right;
      font-weight: 600;
      color: #8292A1;
      font-size: 14px;
      line-height: 20px;
    }

    .email-bottom {
      background: #ffffff;
      text-decoration: none;
      padding: 8px 25px;
      color: #3B298D !important;
      border: 2px solid #3B298D;
      display: inline-block;
      mso-padding-alt: 0;
      text-underline-color: #ff3884;
      transition: .3s;
      font-weight: 600;
    }

    .email-bottom:hover {
      background: #3B298D;
      color: #ffffff !important;
    }

    .email-p {
      font-size: 14px;
      line-height: 20px;
      font-weight: 600;
      color: #8292A1 !important;
      text-decoration: none;
      margin: 0;
    }

    .link {
      font-size: 14px;
      line-height: 20px;
      font-weight: 600;
      color: #8292A1 !important;
      text-decoration: none;
    }

    .link:hover {
      color: #000 !important;
    }

    .social {
      margin: 0 5px;
      text-decoration: none;
      border: 1px solid #e8eced;
    }

    .social:hover {
      border: 1px solid #8293A3 !important;
      border-radius: 50%;
    }

    .social img {
      display: inline-block;
      color: #cccccc;
      width: 40px;
      height: 40px;
      object-fit: contain;
    }

    #contend-mail div {
      display: block;
      padding: 20px;
      border: 1px solid #82929F;
      border-radius: 10px;
      margin: 0 6% !important;
      text-align: left;
    }

    #contend-mail p {
      margin-top: 0;
      color: #36374B;
      font-size: 16px;
      margin-bottom: 10px;
      padding-bottom: 5px;
      border-bottom: 1px solid #82929F;
    }

    #contend-mail p:last-of-type {
      border-bottom: 0;
    }

    #contend-mail strong {
      display: block;
      font-size: 14px;
      color: #82929F;
      margin-bottom: 0;
      font-weight: 400;
    }

    .email-url {
      font-size: 18px;
      font-weight: 600;
      color: #333448 !important;
      text-decoration: none;
    }

    .email-url:hover {
      color: #000 !important;
    }

    @media screen and (max-width: 530px) {
      .email-title, #contend-mail h1 {
        font-size: 18px;
        line-height: 20px;
      }

      .email-message {
        font-size: 16px;
        line-height: 18px;
      }

      .col-md-6 {
        display: block;
        width: 100%;
      }

      .w-60 {
        width: 90%;
      }
    }
  
  </style>
</head>
<body style="margin:0;padding:0;word-spacing:normal;background-color:#E8ECED;">
<div role="article" aria-roledescription="email"
     style="text-size-adjust:100%;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;background-color:#E8ECED;">
  <table role="presentation" style="width:100%;border:none;border-spacing:0;background-color:#E8ECED;">
    <tr>
      <td align="center" style="padding:0;">
        <table class="w-60" role="presentation" align="center">
          <tr>
            <td>
              <table role="presentation" style="border:none;border-spacing:0;">
                <tr>
                  <td style="padding:40px 30px 30px 30px;"></td>
                </tr>
                <tr>
                  <td
                    style="padding:35px 30px 0 30px;font-size:0;background-color:#ffffff;border-color:rgba(201,201,207,.35);border-radius: 10px 10px 0 0;display: flex;  align-items: center;">
                    <table role="presentation" width="100%">
                      <tr>
                        <td>
                          <div class="row">
                            <div class="col-md-6">
                              @php
                                // Default
                                $logo = Setting::get('isite::logo1');
                                // Validation
                                if(Setting::get('notification::logoEmail')){
                                  $settingLogo = json_decode(Setting::get('notification::logoEmail'));
                                  //Cuando lo guardan vacio, esta llegando la relacion media
                                  //Cuando lo guardan, llega la url completa
                                  if(!isset($settingLogo->medias_single)){
                                    $logo = Setting::get('notification::logoEmail');
                                  }
                                }
                                //\Log::info("Logo: ".$logo);
                              @endphp
                              <figure style="margin:0;">
                                <img class="email-logo" src="{{$logo}}"
                                     alt="@setting('core::site-name-mini')">
                              </figure>
                            </div>
                            <div class="col-md-6">
                              <p class="email-date">
                                {{strftime("%d de %B, %G")}}</p>
                            </div>
                          </div>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <tr>
                  <td
                    style="border-radius: 0 0 10px 10px;padding:0 30px 30px;background-color:#ffffff; text-align: center;">
                    <hr style="margin:20px; border: 1px solid #E8ECED;">
                    
                    <img src="http://imgfz.com/i/4KPt72c.png" width="200" alt="imagen"
                         style="width:200px;max-width:80%;height:auto;border:none;text-decoration:none;color:#ffffff; text-align: center;">
                    @yield('content')
                  </td>
                
                </tr>
                <tr>
                  <td
                    style="padding:30px; text-align:center;font-size:12px;background-color:transparent;color:#8292A1;">
                    
                    <p style="margin:0;">
                      @php
                        $social = json_decode(setting("isite::socialNetworks"));
                      @endphp
                      @if(!empty($social->facebook))
                        <a class="social" href="{{$social->facebook}}">
                          <img src="http://imgfz.com/i/nDrdIQH.png" width="40" height="40"
                               alt="facebook"></a>
                      @endif
                      @if(!empty($social->twitter))
                        <a class="social" href="{{$social->twitter}}">
                          <img src="http://imgfz.com/i/qPolSHU.png" width="40" height="40"
                               alt="twitter"></a>
                      @endif
                      @if(!empty($social->instagram))
                        <a class="social" href="{{$social->instagram}}">
                          <img src="http://imgfz.com/i/681nlzH.png" width="40" height="40"
                               alt="instagram"></a>
                      @endif
                      @if(!empty($social->linkedin))
                        <a class="social" href="{{$social->linkedin}}">
                          <img src="http://imgfz.com/i/UPEGlyb.png" width="40" height="40"
                               alt="linkedin"></a>
                      @endif
                      @if(!empty($social->youtube))
                        <a class="social" href="{{$social->youtube}}">
                          <img src="http://imgfz.com/i/zw4CEGu.png" width="40" height="40"
                               alt="youtube"></a>
                      @endif
                    </p>
                    <p style="margin-top: 15px; margin-bottom: 0;">
                      @php
                        $phone = json_decode(setting("isite::phones"));
                        $email = json_decode(setting("isite::emails"));
                      @endphp
                      @if(!empty($phone))
                        <a class="link"
                           href="tel:{{preg_replace('/[^0-9]/', '', $phone[0])}}">{{$phone[0]}}</a>
                      @endif
                      -
                      @if(!empty($email))
                        <a class="link" href="mailto:{{$email[0]}}">{{$email[0]}}</a>
                      @endif
                    </p>
                    <p class="email-p">
                      ©{{date("Y")}} @setting('core::site-name') {{trans('isite::copyright.text')}}
                    </p>
                    <hr style="border-width: 2px;">
                    <p style="margin:0;">
                      <a class="email-url" href="{{url('')}}">{{url('')}}</a>
                    </p>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</div>
</body>
</html>
