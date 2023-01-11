@extends('site.layouts.new-app')

@push('header')

    <title>{{ $meta['title'] ?? '' }}</title>
    <meta name="description" content="{{$meta['description'] ?? ''}}">
    <meta property="og:title" content="{{ $meta['title'] ?? '' }}"/>
    <meta property="og:description" content="{{str_limit($meta['description'] ?? '', 255)}}"/>
    <meta property="og:type" content="website"/>
    <meta property="og:url" content="{{route('tours.index')}}"/>

    <link rel="preload" href="{{ URL::asset(get_webpack_asset('homepage.css')) }}" as="style">
    <link rel="stylesheet" href="{{ URL::asset(get_webpack_asset('homepage.css')) }}">
    <link rel="preload" href="{{ URL::asset(get_webpack_asset('homepage-vendors.css')) }}" as="style">
    <link rel="stylesheet" href="{{ URL::asset(get_webpack_asset('homepage-vendors.css')) }}">
@endpush

@section('content')
    @include('site.homepage.search_form')
    @include('site.homepage.cities')
    @include('site.homepage.text_block')
@endsection

@push('scripts')
    <script type="text/javascript" src="{{ URL::asset(get_webpack_asset('homepage-vendors.js')) }}" defer></script>
    <script type="text/javascript" src="{{ URL::asset(get_webpack_asset('homepage.js')) }}" defer></script>
@endpush
