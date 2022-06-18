<!DOCTYPE html>
<html lang="{{ LaravelLocalization::getCurrentLocale() }}">
<head>
    <meta charset="UTF-8">
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
    {!! Theme::style('css/app.css?v='.setting('isite::appVersion')) !!}
    
    {!! Theme::script('js/app.js?v='.setting('isite::appVersion')) !!}
    
    @stack('css-stack')
    @livewireStyles
    
    {{-- Custom Head JS --}}
    @if(Setting::has('isite::headerCustomJs'))
        {!! Setting::get('isite::headerCustomJs') !!}
    @endif
</head>
<body>

<div id="page-wrapper">
    @include('partials.variables')
    @include('partials.header')
    @yield('content')
    @include('partials.footer')
</div>


{!! Theme::style('css/secondary.css?v='.setting('isite::appVersion'),["rel" => "preload", "as" => "style", "onload" => "this.onload=null;this.rel='stylesheet'"]) !!}
{!! Theme::script('js/secondary.js?v='.setting('isite::appVersion'),["defer" => true]) !!}

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
   {!! Setting::get('isite::customJs') !!}
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
