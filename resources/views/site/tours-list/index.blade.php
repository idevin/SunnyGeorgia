@extends('site.layouts.new-app')
@push('header')

    <title>{{ $meta['title'] ?? '' }}</title>
    <meta name="description" content="{{$meta['description'] ?? ''}}">
    <meta property="og:title" content="{{ $meta['title'] ?? '' }}"/>
    <meta property="og:description" content="{{str_limit($meta['description'] ?? '', 255)}}"/>
    <meta property="og:type" content="website"/>
    <meta property="og:url" content="{{route('tours.index')}}"/>

    <link rel="stylesheet" href="{{ URL::asset(get_webpack_asset('tours-list.css')) }}">
    <link rel="preload" href="{{ URL::asset(get_webpack_asset('tours-list-vendors.css')) }}" as="style">
    @foreach ($cssChunks as $filename)
        <link rel="preload" as="style" href="{{ URL::asset($filename) }}">
    @endforeach

@endpush

@section('content')
    {{--    <tours-city-block></tours-city-block>--}}
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
            <div class="d-none d-lg-block col-lg-3">
                <tours-filter
                        ref="toursFilter"
                        :params="filters.filter"
                        @change="filterChange($event, 'filter')"
                        currency-code="{{$currencyCode}}"
                ></tours-filter>
            </div>
            <div class="col-lg-9">
                <div class="row">
                    <div class="col-12 search-sort-block">
                        <tours-search
                                :params="filters.search"
                                :places="{{$places}}"
                                :total="total"
                                @change="filterChange($event, 'search')"
                        ></tours-search>
                        <tours-mobile-sort
                                :param1="filters.filter"
                                :param2="filters.sort"
                                :total="total"
                                @change1="filterChange($event, 'filter')"
                                @change2="filterChange($event, 'sort')"
                                currency-code="{{$currencyCode}}"
                        ></tours-mobile-sort>
                        <tours-sort
                                :params="filters.sort"
                                :total="total"
                                @change="filterChange($event, 'sort')"
                        ></tours-sort>
                    </div>
                </div>
                <tours-list
                        ref="toursList"
                        @change="filterChange($event, 'page')"
                        @total="total = $event"
                        route-view="{{route('tours.view', ['tour' => ':slug'])}}"
                        route-index="{{route('tours.index')}}"
                        currency-code="{{$currencyCode}}"
                ></tours-list>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript" src="{{ URL::asset(get_webpack_asset('tours-list-vendors.js')) }}" defer></script>
    <script type="text/javascript" src="{{ URL::asset(get_webpack_asset('tours-list.js')) }}" defer></script>
@endpush
