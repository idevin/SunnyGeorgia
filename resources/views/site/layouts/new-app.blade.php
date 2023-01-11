<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    @if(config('app.url') != 'https://sunnygeorgia.travel')
        <meta name="robots" content="noindex, nofollow">
    @endif
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#ffffff">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta property="og:image" content="/images/footer-logo.png"/>
    @yield('head_meta')

    @if(config('app.url') == 'https://sunnygeorgia.travel')
        @include('site.includes.gtagHead')
    @endif
    @include('site.includes.favicons')
    @include('site.includes.js_data')
    @stack('header')
    @stack('styles')

    @include('site.includes.alternates')
    @include('site.includes.utm')
</head>

<body>
@if(config('app.url') == 'https://sunnygeorgia.travel')
    @include('site.includes.gtagBody')
@endif
<div id="app">
    @include('site.includes.nav')

    @yield('content')

    @include('site.includes.footer')

    <auth-modal v-if="modalTab"
                login-route="{{ route('login', [], false) }}"
                register-route="{{ route('register.soft', [], false) }}"
                terms-route="{{ route('terms', [], false) }}"
                forgot-password-route="{{ route('password.email', [], false) }}"
    ></auth-modal>

    <back-to-top>
        <div class="goTop">
            <span class="goTop__arrow">
                <svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="angle-up" role="img"
                     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"
                     class="svg-inline--fa fa-angle-up fa-w-10 fa-3x">
                    <path fill="currentColor"
                          d="M168.5 164.2l148 146.8c4.7 4.7 4.7 12.3 0 17l-19.8 19.8c-4.7 4.7-12.3 4.7-17 0L160 229.3 40.3 347.8c-4.7 4.7-12.3 4.7-17 0L3.5 328c-4.7-4.7-4.7-12.3 0-17l148-146.8c4.7-4.7 12.3-4.7 17 0z"
                    ></path>
                </svg>
            </span>
        </div>
    </back-to-top>
</div>

<!-- Scripts -->
@stack('scripts')

@if(config('app.env') == 'production')
    @include('layouts.envybox')
@endif
</body>
</html>
