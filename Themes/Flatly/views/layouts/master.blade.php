<!DOCTYPE html>
<html lang="{{ LaravelLocalization::getCurrentLocale() }}">
<head>
    <meta charset="UTF-8">
    @section('meta')
        <meta name="description" content="@setting('core::site-description')"/>
    @show
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <title>@section('title')@setting('core::site-name')@show</title>
    @if(isset($alternate))
        @foreach($alternate as $alternateLocale=>$alternateSlug)
            <link rel="alternate" hreflang="{{$alternateLocale}}" href="{{url($alternateLocale.'/'.$alternateSlug)}}">
        @endforeach
    @endif
    <link rel="canonical" href="{{url()->current()}}" />
    <link rel="shortcut icon" href="{{ Theme::url('favicon.ico') }}">
    <link rel="canonical" href="{{canonical_url()}}"/>
    {!! Theme::style('css/main.css?v='.config('app.version')) !!}

    @stack('css-stack')
</head>
<body>
<div id="page-wrapper">
    @include('partials.header')
    @yield('content')
    @include('partials.footer')
</div>
@auth
    @include('partials.admin-bar')
@endauth
@include('partials.navigation')

<div class="container">
    @yield('content')
</div>
@include('partials.footer')

{!! Theme::style('css/secondary.css?v='.config('app.version')) !!}
{!! Theme::script('js/app.js?v='.config('app.version')) !!}
{!! Theme::script('js/all.js?v='.config('app.version')) !!}
{!! Theme::script('js/secondary.js?v='.config('app.version')) !!}

@yield('scripts-owl')
@yield('scripts')


{{-- Custom CSS --}}
@php $customCSS = @setting('isite::custom-css'); @endphp
@if(isset($customCSS) && !empty($customCSS))
<style> {!! $customCSS !!} </style>
@endif


{{-- Custom JS --}}
@php $customJS = @setting('isite::custom-js'); @endphp
@if(isset($customJS) && !empty($customJS))
    <script> {!! $customJS !!} </script>
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
