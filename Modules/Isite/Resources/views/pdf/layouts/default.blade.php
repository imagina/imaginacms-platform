<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <style type="text/css" media="all">
    /**
               Establezca los márgenes de la página en 0, por lo que el pie de página y el encabezado
               puede ser de altura y anchura completas.
            **/

    @page {   margin: 50px 0cm; }
    @page :first{
      margin: 0cm 0cm;
      border-top: 9px solid{{setting("isite::brandPrimary")}};
    }
    
    body{
      margin: 0;
    }
    

    main {
      margin-top: 0cm;
      margin-left: 1cm;
      margin-right: 1cm;
      margin-bottom: 1cm;
    }


    td, th {
      padding: 8px;
    }

    tr:nth-child(even){background-color: #f2f2f2;}

    tr:hover {background-color: #ddd;}

    th {
      padding-top: 12px;
      padding-bottom: 12px;
      text-align: left;
    }
    
    .items-list-wrapper {
      justify-content: center;
    }
    
    .d-inline-block {
      display: inline-block !important;
    }
    
    .mr-2{
      margin-right: 0.5rem !important;
    }
   
    .editLink {
      display: none;
    }
    
    .align-self-center{
      align-self: center !important;
    }
    
    .header-content {
      border-top: 9px solid {{setting("isite::brandPrimary")}};
      padding: 15px 0;
    }

    .header-content h1 {
      text-align: left;
    }
    
    .header-content .content-site-data .content-address {
      text-align: left;
    }
    
    .header-content .content-site-data i {
      text-align: center;
      width: 28px;
      height: 12px;
      border-radius: 100%;
      margin-right: px;
      color: {{setting("isite::brandPrimary")}};
      padding-top: 5px;
      -webkit-margin-after: 10px;
      margin-block-end: 10px;
      display: none;
    }
    
    .header-content .content-site-data a {
      margin-bottom: 8px;
      font-size: 10px;
      text-decoration: none;
      color: #3C3C3B;
      text-align: left;
      width: 100%;
    }
    .header-content img {

      max-height: 90px;
      max-width: 500px;
    }


    .header-bottom {
      border-top: 1px solid #ebebeb;
    }
    
    .header-bottom .date {
      padding: 7px 15px;
      background-color: #ebebeb;
      margin-right: 90px;
      float: right;
    }

    #content{
      position: relative;
    }
    .dropdown-whatsapp .dropdown-menu-whatsapp a {
      font-size: 14px !important;
      font-weight: normal !important;
      margin: 0 8px !important;
      line-height: normal;
      color: {{setting("isite::brandPrimary")}}    !important;
    }
    
    
    footer .app-url {
      text-align: center;
      padding: 12px;
      background-color: white;
    }
    
    footer .app-url a {
      text-decoration: none;
      color: #0A0808;
      font-size: 10px;
    }
  </style>
</head>
<body>
<header>
  
  <div class="header-content">
    <table width="100%">
      <tbody>
      <tr>
        <td width="70%">
          <img class="align-self-center" src="@setting('isite::'.setting('isite::pdfLogoHeader'))" alt="Logotipo">
        </td>
        
        <td width="30%">
          <h1 id="siteName" style="font-size: 16px">{!!setting("core::site-name")!!}</h1>
          <div class="content-site-data">
    
            <x-isite::contact.phones/>
    
            <x-isite::contact.emails/>
    
            <x-isite::contact.addresses/>
          </div>
        </td>
      </tr>
      </tbody>
    </table>
  </div>
  
  <div class="header-bottom">
    <div class="date" style="display: inline-block; font-size: 10px">Fecha: <?php echo date("Y/m/d")?></div>
  </div>

</header>



<main>
  <div id="content">
    <br>
    <meta charset="UTF-8">
    <div id="pdfPreContent">{!!setting("isite::pdfPreContent")!!}</div>
    <div id="pdfContent">
      @if(isset($data["content"]))
        @include($data["content"],$data)
      @else
        {{trans("isite::pdf.settings.pdf.text.Document_without_content")}}
      @endif
    </div>
  </div>
  <div id="pdfPostContent">{!!setting("isite::pdfPostContent")!!}</div>
</main>

<footer id="layoutFooter">
  <table width="100%">
    <tbody>
    <tr>
      <td width="50%" style="background-color: {{setting("isite::brandPrimary")}}"> &nbsp;</td>
      <td width="50%" style="background-color: #ebebeb">
      <div class="app-url">
        <a href="{{url(env("APP_URL"))}}">   {{env("APP_URL")}}</a>
      </div>
      </td>
    </tr>
    </tbody>
  </table>
</footer>
</body>
</html>