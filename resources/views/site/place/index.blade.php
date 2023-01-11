@extends('site.layouts.new-app')
@push('header')
    <title>{{ $meta['title'] ?? '' }}</title>
    <meta name="description" content="{{$meta['description'] ?? ''}}">
    <meta property="og:title" content="{{ $meta['title'] ?? '' }}"/>
    <meta property="og:description" content="{{str_limit($meta['description'] ?? '', 255)}}"/>
    <meta property="og:type" content="website"/>
    <meta property="og:url" content="{{route($place->slug)}}"/>

    <link rel="preload" href="{{ URL::asset(get_webpack_asset('place-vendors.css')) }}" as="style" onload="this.rel='stylesheet'">
{{--    <link rel="preload" href="{{ URL::asset(get_webpack_asset('place.css')) }}" as="style" onload="this.rel='stylesheet'">--}}
      @foreach ($cssChunks as $filename)
        <link rel="preload" href="{{ URL::asset($filename) }}" as="style" onload="this.rel='stylesheet'">
      @endforeach
    {{--  <link rel="stylesheet" href="{{ URL::asset(resource_path('assets/common-styles/aside.css')) }}">--}}
    <link rel="stylesheet" href="{{ URL::asset(get_webpack_asset('place.css')) }}">
{{--    <link rel="stylesheet" href="{{ URL::asset(get_webpack_asset('place-vendors.css')) }}">--}}
@endpush

@section('content')
    <div class="page-wrapper">
        <main class="page-main">
            <div class="search-block-wrap">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            {{ Breadcrumbs::view('breadcrumbs::json-ld', Request::route()->name) }}
                            {{ Breadcrumbs::render(Request::route()->name) }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="container main-content">
                <div class="row">
                    <div class="col-lg-3 order-2 order-lg-1">
                        <side-bar inline-template>
                            @include('site.place.aside', $asideData)
                        </side-bar>
                    </div>
                    <div class="col-lg-9 order-1 order-lg-2">
                        <div class="row">
                            <div class="col-12 search-sort-block">
                                <h1>{{$place->name}}</h1>
                                <cms-content>
                                    {!! $place->page !!}
                                </cms-content>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @push('place_navigation')
                <place-navigation page="{{$page}}"></place-navigation>
            @endpush
        </main>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript" src="{{ URL::asset(get_webpack_asset('place-vendors.js')) }}" defer></script>
    <script type="text/javascript" src="{{ URL::asset(get_webpack_asset('place.js')) }}" defer></script>
@endpush
