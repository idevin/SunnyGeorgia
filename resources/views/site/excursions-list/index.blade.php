@extends('site.layouts.new-app')
@push('header')
    <title>{{ $meta['title'] ?? '' }}</title>
    <meta name="description" content="{{$meta['description'] ?? ''}}">
    <meta property="og:title" content="{{ $meta['title'] ?? '' }}"/>
    <meta property="og:description" content="{{str_limit($meta['description'] ?? '', 255)}}"/>
    <meta property="og:type" content="website"/>
    <meta property="og:url" content="{{route('excursions.index')}}"/>

    <link rel="prefetch" href="{{ URL::asset(get_webpack_asset('excursions-list-vendors.css')) }}" as="style">
    @foreach ($cssChunks as $filename)
        <link rel="prefetch" href="{{ URL::asset($filename) }}" as="style">
    @endforeach
    <link rel="stylesheet" href="{{ URL::asset(get_webpack_asset('excursions-list-vendors.css')) }}">
    <link rel="stylesheet" href="{{ URL::asset(get_webpack_asset('excursions-list.css')) }}">

@endpush
@section('content')
    <main class="page-main">
        <div class="search-block-wrap">
            <div class="container">
                <div class="row justify-content-end">
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
                    <excursions-filter
                            ref="excursionsFilter"
                            :params="filters.filter"
                            @change="filterChange($event, 'filter')"
                            currency-code="{{$currencyCode}}"
                    ></excursions-filter>
                </div>
                <div class="col-lg-9">
                    <div class="row">
                        <div class="col-12 search-sort-block">
                            <excursions-search
                                    :params="filters.search"
                                    :places="{{$places}}"
                                    :total="total"
                                    @change="filterChange($event, 'search')"
                            ></excursions-search>
                            <excursions-mobile-sort
                                    :param1="filters.filter"
                                    :param2="filters.sort"
                                    :total="total"
                                    @change1="filterChange($event, 'filter')"
                                    @change2="filterChange($event, 'sort')"
                                    currency-code="{{$currencyCode}}"
                            ></excursions-mobile-sort>
                            <excursions-sort
                                    :params="filters.sort"
                                    :total="total"
                                    @change="filterChange($event, 'sort')"
                            ></excursions-sort>
                        </div>
                    </div>
                    <excursions-list
                            ref="excursionsList"
                            @change="filterChange($event, 'page')"
                            @total="total = $event"
                            route-view="{{route('excursions.view', ':slug')}}"
                            route-index="{{route('excursions.index')}}"
                            currency-code="{{$currencyCode}}"
                            :current-place="filters.search.place"
                    ></excursions-list>
                </div>
            </div>
        </div>
    </main>
@endsection


@push('scripts')
    <script type="text/javascript" src="{{ URL::asset(get_webpack_asset('excursions-list-vendors.js')) }}" defer></script>
    <script type="text/javascript" src="{{ URL::asset(get_webpack_asset('excursions-list.js')) }}" defer></script>
@endpush