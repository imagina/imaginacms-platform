<!DOCTYPE html>
<html lang="{{ LaravelLocalization::getCurrentLocale() }}">
<head>
  <meta charset="UTF-8">
  @yield('meta')
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}"/>
  <title>@section('title')@setting('core::site-name')@show</title>
  @if(isset($alternate))
    @foreach($alternate as $link)
      {!! $link["link"] !!}
    @endforeach
  @endif
  <link rel="shortcut icon" href="@setting('isite::favicon')">
  <link rel="canonical" href="{{canonical_url()}}"/>

  @if(isset(tenant()->id))
    <link rel="stylesheet" as="style"  href="{{tenant()->url.'/themes/'.strtolower(setting('core::template', null, 'ImaginaTheme')).'/'.'css/app.css?v='.setting('isite::appVersion')}}" />

    <script src="{{tenant()->url.'/themes/'.strtolower(setting('core::template', null, 'ImaginaTheme')).'/'.'js/app.js?v='.setting('isite::appVersion')}}" ></script>
  @else
    {!! Theme::style('css/app.css?v='.setting('isite::appVersion')) !!}

    {!! Theme::script('js/app.js?v='.setting('isite::appVersion')) !!}
  @endif

  @stack('css-stack')
  @livewireStyles

  {{-- Custom Head JS --}}
  @if(Setting::has('isite::headerCustomJs'))
    {!! Setting::get('isite::headerCustomJs') !!}
  @endif

  {{--Fontawesome--}}
  <script src="https://kit.fontawesome.com/56d3d5dce0.js" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/js/v4-shims.min.js" integrity="sha512-pd9YFLsGdZIRG1ChLLdpxgGT+xR7rVjsHqm6RP0toUadPB4XZZ7LlqzX3IhnpMd2Cb8b2s8yVFwY21epgr84qw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>
<body>

<div id="page-wrapper">
  @include('partials.variables')
  @include('isite::frontend.partials.colors')
  @yield('content')
</div>

@if(isset(tenant()->id))
  <link href="{{tenant()->url.'/themes/'.strtolower(setting('core::template', null, 'ImaginaTheme')).'/'.'css/secondary.css?v='.setting('isite::appVersion')}}" rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'" />

  <script src="{{tenant()->url.'/themes/'.strtolower(setting('core::template', null, 'ImaginaTheme')).'/'.'js/secondary.js?v='.setting('isite::appVersion')}}" defer="true"></script>
@else

  {!! Theme::style('css/secondary.css?v='.setting('isite::appVersion'),["rel" => "preload", "as" => "style", "onload" => "this.onload=null;this.rel='stylesheet'"]) !!}
  {!! Theme::script('js/secondary.js?v='.setting('isite::appVersion'),["defer" => true]) !!}
@endif

@livewireScripts
<x-livewire-alert::scripts />

<script defer type="text/javascript" src="https://platform-api.sharethis.com/js/sharethis.js#property=5fd9384eb64d610011fa8357&product=inline-share-buttons" async="async"></script>
@yield('scripts-owl')
@yield('scripts-header')
@yield('scripts')


{{-- Custom CSS --}}
@if((Setting::has('isite::customCss')))
  <style> {!! Setting::get('isite::customCss') !!} </style>
@endif


{{-- Custom JS --}}
@if(Setting::has('isite::customJs'))
  <script> {!! Setting::get('isite::customJs') !!} </script>
@endif


<?php if (Setting::has('isite::chat')): ?>
{!! Setting::get('isite::chat') !!}
<?php endif; ?>

<?php if (Setting::has('core::analytics-script')): ?>
{!! Setting::get('core::analytics-script') !!}
<?php endif; ?>
@stack('js-stack')
</body>
</html>
