<!DOCTYPE html>
<html lang="en">
<!-- begin::Head -->
<head>
    <meta charset="utf-8"/>
    <title>{{config('app.name')}} Dashboard</title>
    <meta name="description" content="Latest updates and statistic charts">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta id="csrf-token" name="csrf-token" content="{{ csrf_token() }}">

    <link rel="apple-touch-icon" sizes="180x180" href="/favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicons/favicon-16x16.png">
    <link rel="manifest" href="/favicons/manifest.json">
    <link rel="mask-icon" href="/favicons/safari-pinned-tab.svg" color="#2b5797">
    <meta name="theme-color" content="#ffffff">
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
            'user' => Auth::user(),
            'url_params' => Request::all(),
            'status' => Session::get('status'),
            'msg' => Session::get('msg'),
            'success' => Session::get('success'),
            'errors' => $errors->all()
        ]) !!};
    </script>
    <!--begin::Web font -->
    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
    <link href="https://fonts.googleapis.com/css?family=PT+Sans:400,400i,700,700i&subset=cyrillic,cyrillic-ext,latin-ext"
          rel="stylesheet">
    <!--end::Web font -->
    <!--begin::Base Styles -->
    <!--begin::Page Vendors -->
    <link href="/assets/vendors/custom/fullcalendar/fullcalendar.bundle.css" rel="stylesheet" type="text/css"/>
    <!--end::Page Vendors -->
    <link href="/assets/vendors/base/vendors.bundle.css" rel="stylesheet" type="text/css"/>
    <link href="/assets/demo/default/base/style.bundle.css" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset(get_webpack_asset('cabinet-vendors.css')) }}" rel="stylesheet">
    <link href="{{ URL::asset(get_webpack_asset('cabinet.css')) }}" rel="stylesheet">

@stack('styles')
<!--end::Base Styles -->
    <link rel="shortcut icon" href="/assets/demo/default/media/img/logo/favicon.ico"/>
</head>
<!-- end::Head -->
<!-- end::Body -->
{{--<body class="m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">--}}
<body class="m-page--fluid m--skin- m-content--skin-light2 m-aside-left--enabled m-aside-left--skin-dark m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">
<!-- begin:: Page -->
<div class="m-grid m-grid--hor m-grid--root m-page" id="cabinet-app">
@include('cabinet.layouts.header')
<!-- begin::Body -->
    <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">
        <!-- BEGIN: Left Aside -->
        <button class="m-aside-left-close  m-aside-left-close--skin-dark " id="m_aside_left_close_btn">
            <i class="la la-close"></i>
        </button>
        <div id="m_aside_left" class="m-grid__item	m-aside-left  m-aside-left--skin-dark ">
            @include('cabinet.layouts.aside')
        </div>

        <!-- END: Left Aside -->
        @yield('content')
    </div>
    <!-- end:: Body -->
    <!-- begin::Footer -->
@yield('footer')
<!-- end::Footer -->
    <bug-reporter form-action="{{route('cabinet:bug')}}"></bug-reporter>
</div>
<!-- end:: Page -->

<!-- begin::Scroll Top -->
<div class="m-scroll-top m-scroll-top--skin-top" data-toggle="m-scroll-top" data-scroll-offset="500"
     data-scroll-speed="300">
    <i class="la la-arrow-up"></i>
</div>
<!-- end::Scroll Top -->
{{--@include('cabinet.layouts.notifications')--}}
<!--begin::Base Scripts -->
<script src="/assets/vendors/base/vendors.bundle.js" type="text/javascript"></script>
<script src="/assets/demo/default/base/scripts.bundle.js" type="text/javascript"></script>
<!--end::Base Scripts -->
<!--begin::Page Vendors -->
<script src="/assets/vendors/custom/fullcalendar/fullcalendar.bundle.js" type="text/javascript"></script>
<!--end::Page Vendors -->
<!--begin::Page Snippets -->
{{--<script src="/assets/app/js/dashboard.js" type="text/javascript"></script>--}}
<!--end::Page Snippets -->
<!-- Scripts -->
<script type="text/javascript" src="{{ URL::asset(get_webpack_asset('cabinet-vendors.js')) }}"></script>
<script type="text/javascript" src="{{ URL::asset(get_webpack_asset('cabinet.js')) }}"></script>
@stack('scripts')

{{--@include('site.layouts.js_data')--}}
</body>
<!-- end::Body -->
</html>
