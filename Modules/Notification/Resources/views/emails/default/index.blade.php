<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
  @includeFirst(['emails.style', 'notification::emails.base.style'])
  
  <style type="text/css">
    #body {
      
      border-radius: 10px;
      
      color: #333333;
      font-family: Roboto,-apple-system,Helvetica Neue,Helvetica,Arial,sans-serif;
    }
    
    .date {
      color: white;
    }
    
    #template-mail {
      
      border-bottom: 20px solid #cc1937;
      width: 70%;
      margin: auto;
    }
    
    @media only screen and (max-width: 900px) {
      #template-mail {
        width: 100%;
      }
    }
    
    #contenido {
      padding: 15px;
    }
    
    header .header-top {
      padding: 15px;
    }
    
    footer {
      background-color: #1B2126;
      color: white;
    }
    
    footer .copyright {
      color: #e2e2e2;
      font-size: 14px;
    }
    
    .stripe {
      background: rgb(204,25,55);
      background: -moz-linear-gradient(114deg, rgba(204,25,55,1) 35%, rgba(27,33,38,1) 115%);
      background: -webkit-linear-gradient(114deg, rgba(204,25,55,1) 35%, rgba(27,33,38,1) 115%);
      background: linear-gradient(114deg, rgba(204,25,55,1) 35%, rgba(27,33,38,1) 115%);
      filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="#cc1937",endColorstr="#1b2126",GradientType=1);
      padding: 20px;
    }
    
    /********* form ************/
    .btn-requirement {
      padding: 25px 0;
    }
    
    .btn-requirement a {
      text-decoration: none;
      background-color: #cc0909;
      padding: 10px;
      margin: 10px 0;
      color: white;
    }
    
    .seller {
      margin-top: 20px;
    }
    
    .seller span {
      font-style: italic;
    }
    
    .seller h3, .seller h4 {
      margin: 2px;
      font-weight: 400;
      
    }
    .avatar-img-component{
      border: 1px solid #37474f;
      border-radius: 50%;
      padding: 3px;
      width: -webkit-max-content;
      width: -moz-max-content;
      width: max-content;
    }
    .avatar-img-content{
      border-radius: 50%;
      background-position: 50%;
      background-repeat: no-repeat;
      background-size: cover;
    }
    .contacto {
      background-color: #009b54;
      color: #e2e2e2;
      padding: 15px;
    }
    
    .contacto a {
      color: #e2e2e2;
    }
    
    /******** class **********/
    .float-left {
      float: left !important
    }
    
    .float-right {
      float: right !important
    }
    
    .float-none {
      float: none !important
    }
    
    .text-justify {
      text-align: justify !important
    }
    
    .text-nowrap {
      white-space: nowrap !important
    }
    
    .text-truncate {
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap
    }
    
    .text-left {
      text-align: left !important
    }
    
    .text-right {
      text-align: right !important
    }
    
    .text-center {
      text-align: center !important
    }
    
    .text-uppercase {
      text-transform: uppercase;
    }
    
    .text-capitalize {
      text-transform: capitalize;
    }
    
    .container {
      width: 85%;
      margin: auto;
    }
    .rounded {
      border-radius: .25rem!important;
    }
    .p-3 {
      padding: 1rem !important
    }
    
    .px-3 {
      padding: 0 1rem !important
    }
    
    .py-3 {
      padding: 1rem 0 !important
    }
    .btn-danger {
      color: #fff;
      background-color: #dc3545;
      border-color: #dc3545;
    }
    .btn {
      text-decoration: none;
      display: inline-block;
      font-weight: 400;
      text-align: center;
      white-space: nowrap;
      vertical-align: middle;
      -webkit-user-select: none;
      -moz-user-select: none;
      -ms-user-select: none;
      user-select: none;
      border: 1px solid transparent;
      padding: .375rem .75rem;
      font-size: 1rem;
      line-height: 1.5;
      border-radius: .25rem;
      transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
    }
    
    .content{
      text-align: left;
      margin-bottom: 5px;
    }
    table{
      word-wrap: break-word;
      width: 100%;
    }
  
  </style>
</head>

<body>
<div id="body">
  <div id="template-mail">
  
    <div class="header" style="background: {{Setting::get('site::color-primary')}};">
      <!-- header contend -->
      <div class="stripe" style="background: {{Setting::get('site::color-secondary')}};
        padding: 10px 20px;">
        <div class="text-right text-capitalize" style="text-align: right !important; text-transform: capitalize;">
          {{strftime("%B %d, %G")}}
        </div>
      </div>
    
      <div>
        <h1 class="title" style="text-align: center;
        width: 80%;
        font-size: 40px;
        margin: 74px auto;">
          {{trans('notification::messages.new-notification')}}
        </h1>
      </div>
    
      <div class="header-contend text-center py-3" style="padding: 1rem 0 !important; ">
        <div style=" border-radius: 50%;
          max-width: 150px;
          height: 150px;
          background: #fff;
          margin: auto;
          padding: 10px;
          overflow: hidden;
          border: {{Setting::get('site::color-primary')}} solid;
          z-index: 10000;">
          <img src="{{Setting::get('isite::logo1')}}" alt="" style="max-width: 120px; margin-top: 20px;">
        </div>
      </div>
    <div class="container" align="center" style="margin: 120px auto 70px;
            box-shadow: 0px 0px 20px #a99b9b; width: 70%; padding: 30px; border: 1px solid #ccc;">
          
      <h3 class="text-center text-uppercase">
        {{$data["title"]}}
      </h3>
      
      <br>
      <!--
      <p class="px-3">
        <strong>Mr/Mrs:</strong> {{--**$user->first_name**--}} {{--**$user->last_name**--}}
      </p>
      -->
      <div class="row" style="display: inline-flex;">
        <div style="width: 70%; margin: 0 auto; padding: 0 5px">
          
              <p>{{$data["message"]}}</p>
  
          <a href="{{$data["link"]}}" style="cursor: pointer;">
            <label style="    border-radius: 4px;
              padding: 11px 0px 11px 0px;
              margin-top: 12px;
              text-align: center;
              display: inline-block;
              color: #ffffff;
              background-color: {{setting('isite::brandPrimary')}};
              font-weight: bold;
              width: 100%;
              font-size: 15px;">
              {{trans('notification::messages.new-notification')}}
            </label>
          </a>
     
           
        </div>
      
      </div>
    </div>
    <hr style="border:none;
        height: 46px;
        width: 90%;
        box-shadow: 0 20px 20px -20px #333;
        margin: -50px auto 10px;">
    
    @includeFirst(['emails.footer', 'notification::emails.base.footer'])
  
  
  </div>
</div>
</body>

</html>
