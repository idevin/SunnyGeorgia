<!doctype html>
<html class="no-js" lang="{{ app()->getLocale() }}">
<head>
    <meta name="fragment" content="!">
    <meta charset="utf-8">
    @if(config('app.url') != 'https://sunnygeorgia.travel')
        <meta name="robots" content="noindex, nofollow">
    @endif
    @if(config('app.url') == 'https://sunnygeorgia.travel')
        @include('site.includes.gtagHead')
    @endif
    @yield('head_meta')
    <title>{{ $meta['title'] ?? '' }}</title>
    <meta name="description" content="{{$meta['description'] ?? ''}}">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#ffffff">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta property="og:image" content="/images/footer-logo.png"/>
    @include('site.includes.js_data')

    <link rel="icon" type="image/png" sizes="32x32" href="/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicons/favicon-16x16.png">
    <link rel="apple-touch-icon" type="image/png" sizes="180x180" href="/favicons/apple-touch-icon.png">
    <link rel="manifest"  href="/favicons/manifest.json">
    <link rel="mask-icon" href="/favicons/safari-pinned-tab.svg" color="#2b5797">

    <link href="https://fonts.googleapis.com/css?family=PT+Sans:400,700|Open+Sans:300,400" rel="stylesheet"> <!-- Move this to style files-->

    <!-- Styles -->
    @section('styles')
        <link rel="stylesheet" href="{{ URL::asset(get_webpack_asset('app-vendors.css')) }}">
        <link rel="stylesheet" href="{{ URL::asset(get_webpack_asset('app.css')) }}">
    @endsection

    @yield('styles')
    @stack('header')

    @include('site.includes.alternates')
    @include('site.includes.utm')
</head>

<body class="page">
@if(config('app.url') == 'https://sunnygeorgia.travel')
    @include('site.includes.gtagBody')
@endif
<div id="app">
    @include('site.layouts.app_svg')
    <!--wrapper-->
    @include('site.includes.nav')
    <div class="page-wrapper">
        @yield('content')
    </div>
    @include('site.includes.footer')
        <!--end wrapper-->

    {{--@guest--}}
    <auth-modal
            v-if="modalTab"
            login-route="{{ route('login', [], false) }}"
            register-route="{{ route('register.soft', [], false) }}"
            terms-route="{{ route('terms', [], false) }}"
            forgot-password-route="{{ route('password.email', [], false) }}"
    ></auth-modal>
    {{--@endguest--}}
    <back-to-top></back-to-top>
</div>

<!-- Scripts -->
@yield('scripts')
@stack('scripts')

    <script type="text/javascript" src="{{ URL::asset(get_webpack_asset('app-vendors.js')) }}"></script>
    <script type="text/javascript" src="{{ URL::asset(get_webpack_asset('app.js')) }}"></script>


{{--<script src="{{ route('i18n-js') }}"></script>--}}

@if(config('app.env') == 'production')
{{--    @include('layouts.jivosite')--}}
@endif
</body>
</html>
