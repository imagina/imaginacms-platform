<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    <style type="text/css">
        #body {
            background-color: #e2e2e2;
            padding: 20px 0;
            color: #333333;
            font-family: 'Open Sans', sans-serif;
        }

        .date {
            color: white;
        }

        #template-mail {
            background-color: #ffffff;
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
            background-color:{{Setting::get('site::color-secondary')}};
            color: white;
        }

        footer .copyright {
            color: #e2e2e2;
            font-size: 14px;
        }

        .stripe {
            background-color: {{Setting::get('site::color-secondary')}};
            padding: 10px 20px;
        }

        /********* form ************/
        .btn-requirement {
            padding: 25px 0;
        }

        .btn-requirement a {
            text-decoration: none;
            background-color:{{Setting::get('site::color-primary')}};
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
            text-align: center;
        }

        .contacto {
            background-color:{{Setting::get('site::color-primary')}};
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

        .p-3 {
            padding: 1rem !important
        }

        .px-3 {
            padding: 0 1rem !important
        }

        .py-3 {
            padding: 1rem 0 !important
        }
    </style>

</head>

<body>
<div id="body">
    <div id="template-mail">
        <header>

            <!-- header contend -->
            <div class="stripe">
                <div class="date text-right text-capitalize">
                    {{strftime("%B %d, %G")}}
                </div>
            </div>
            <div class="header-contend text-center py-3">
                <img src="{{Setting::get('site::logo-1')}}" alt="" style="max-width: 150px">
            </div>

        </header>

        @yield('content')

        <footer class="p-3 text-center">
            <div class="text-center">
                <img src="{{Setting::get('site::logo-2')}}" alt="" style="max-width: 150px">

            </div>

            <div class="contacto">

            </div>

            <span class="copyright">
                Copyrights © 2018 All Rights Reserved by {{ setting('core::site-name') }}.
            </span>
        </footer>
    </div>
</div>
</body>

</html>