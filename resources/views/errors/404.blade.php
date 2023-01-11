@php
    URL::defaults(['locale' => app()->getLocale()]);
@endphp
@extends('site.layouts.new-app')
@push('header')
    <meta name="robots" content="noindex, follow">

    <link rel="preload" href="{{ URL::asset(get_webpack_asset('information-pages-vendors.css')) }}" as="style">
    {{--  @foreach ($cssChunks as $filename)--}}
    {{--    <link rel="preload" href="{{ URL::asset($filename) }}" as="style">--}}
    {{--  @endforeach--}}
    <link rel="stylesheet" href="{{ URL::asset(get_webpack_asset('information-pages-vendors.css')) }}">
    <link rel="stylesheet" href="{{ URL::asset(get_webpack_asset('information-pages.css')) }}">
    <style>
        body {
            height: 100vh;
        }
        #app {
            display: flex;
            flex-flow: column;
            height: 100%;
            overflow: hidden;
        }
    </style>
@endpush

@section('content')
    <!--main-->
    <main
            class="page-main"
            style="flex: 1; display: flex; align-items: center; justify-content: center"
    >
        <div class="cms-content terms bg-white m-0 py-4">
            <div class="container">
                <div class="col text-center">
                    <br>
                    <h1 class="text-center">404</h1>
                    <h3 class="text-center">{!! trans('main.Page not found')!!}</h3>
                    <br>
                    <a href="{{route('main')}}" class="btn btn-outline-primary">{{trans('main.Main')}}</a>
                </div>
            </div>
        </div>
    </main>
    <!--end main-->
@endsection

@push('scripts')
    <script type="text/javascript" src="{{ URL::asset(get_webpack_asset('information-pages-vendors.js')) }}"
            defer></script>
    <script type="text/javascript" src="{{ URL::asset(get_webpack_asset('information-pages.js')) }}" defer></script>
@endpush
