@extends('site.layouts.new-app')

@push('header')
    <link rel="prefetch" href="{{ URL::asset(get_webpack_asset('information-pages-vendors.css')) }}" as="style">
    <link rel="stylesheet" href="{{ URL::asset(get_webpack_asset('information-pages-vendors.css')) }}">
    <link rel="stylesheet" href="{{ URL::asset(get_webpack_asset('information-pages.css')) }}">
@endpush

@section('content')
    <main class="page-main" id="excursion_checkout_2">
        <div class="container">
            <ul class="step list-unstyled mb-3">
                <li class="step-item active">
                    <span class="step-count">1</span>
                    <span class="step-text">{{trans('checkout.Order details')}}</span>
                </li>
                <li class="step-item active">
                    <span class="step-count">2</span>
                    <span class="step-text">{{trans('checkout.Payment')}}</span>
                </li>
                <li class="step-item active">
                    <span class="step-count">3</span>
                    <span class="step-text">{{trans('checkout.End of booking')}}</span>
                </li>
            </ul>
            @include("site.excursions.check_ticket")
        </div>
    </main>
@endsection

@push('scripts')
    <script type="text/javascript" src="{{ URL::asset(get_webpack_asset('information-pages-vendors.js')) }}" defer></script>
    <script type="text/javascript" src="{{ URL::asset(get_webpack_asset('information-pages.js')) }}" defer></script>
@endpush

@push('styles')
    <style>
        .checkout-form {
            border-radius: 5px;
            border-radius: 0.3125rem;
            background-color: #fff;
        }

        .checkout-title {
            color: #0e4061;
            font-family: "Open Sans", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
            font-size: 24px;
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 26px;
            display: block;
        }

        .checkout-text {
            color: #424242;
            font-size: 13px;
            font-size: 0.8125rem;
            letter-spacing: 0.33px;
            margin-bottom: 10px;
        }

        .checkout-providers img {
            max-width: 100%;
            height: auto;
            width: 50px;
        }

        .checkout-btn {
            min-width: 160px;
            font-weight: 700;
            font-size: 16px;
            font-size: 1rem;
            padding: 8px 15px;
            padding: 0.5rem 0.9375rem;
        }

        .checkout-small {
            font-size: 12px;
            font-size: 0.75rem;
        }

        .checkout-list {
            margin-top: 15px;
        }

        .checkout-list li {
            margin-bottom: 15px;
        }

        .checkout-list p {
            margin: 0;
            color: #000;
        }

        .checkout-list p:not(:last-child){
            margin-bottom: 4px;
        }

        .checkout-list li {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
        }

        .checkout-list li > strong {
            display: block;
            width: 150px;
            color: #0e4061;
            font-size: 14px;
            font-size: 0.875rem;
            font-weight: 400;
            letter-spacing: 0.35px;
            margin-right: 15px;
            -ms-flex-negative: 0;
            flex-shrink: 0;
        }

        .checkout-help {
            color: #393939;
            font-family: "Open Sans", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
            font-size: 10px;
            font-size: 0.625rem;
            letter-spacing: 0.25px;
        }

        .checkout-order {
            background-color: #f6f6f6;
            padding: 15px 20px;
            padding: 0.9375rem 1.25rem;
            border-top: 1px solid #464646;
            margin-top: 5px;
        }

        .checkout-order-text {
            color: #464646;
            font-family: "Open Sans", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
            font-size: 16px;
            font-size: 1rem;
            font-weight: 700;
            letter-spacing: 0.4px;
            display: block;
            text-align: center;
        }

        .checkout-order-days {
            color: #5f5f5f;
            font-size: 12px;
            font-size: 0.75rem;
            display: block;
            text-align: center;
            margin-bottom: 10px;
        }

        .checkout-order-label {
            color: #5f5f5f;
            font-size: 12px;
            font-size: 0.75rem;
            font-family: "Open Sans", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
            font-weight: 700;
            letter-spacing: 0.4px;
            display: block;
            line-height: 1;
            margin-bottom: 5px;
        }

        .checkout-order-count {
            color: #000;
            font-size: 22px;
            font-size: 1.375rem;
            font-weight: 700;
            text-transform: uppercase;
            line-height: 1;
            display: block;
        }

        .checkout-order-sum {
            margin-top: 15px;
        }

        .checkout-order-sum .checkout-order-label {
            color: #0e4061;
            font-size: 16px;
            font-size: 1rem;
            font-weight: 700;
        }

        .checkout-order-sum .checkout-order-count {
            color: #0e4061;
            font-size: 30px;
            font-size: 1.875rem;
            font-weight: 700;
        }

        .checkout-user p {
            color: #000;
            font-family: "Open Sans", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
        }

        .checkout-user p strong {
            font-family: "PT Sans", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
        }

        .checkout-contacts h2 {
            font-size: 16px;
            font-size: 1rem;
            font-weight: 700;
        }

        .checkout-contacts li + li {
            margin-top: 5px;
        }

        .checkout-contacts li > span {
            margin-right: 5px;
            color: #0e4061;
            font-size: 13px;
            font-size: 0.8125rem;
            letter-spacing: 0.33px;
        }

        .checkout-contacts li > strong {
            display: inline;
            font-weight: normal;
            font-size: 13px;
            font-size: 0.8125rem;
        }

        .checkout-contacts li:last-child {
            white-space: nowrap;
        }

        .checkout-contacts li:last-child span {
            vertical-align: top;
        }

        .checkout-contacts li:last-child > strong {
            display: inline-block;
        }

        .checkout-contacts li:last-child > strong span {
            display: block;
        }

        .checkout-contacts li:last-child > strong span + span {
            margin-top: 5px;
        }

        .checkout-result-complete {
            border-radius: 5px;
            border: 1px solid #464646;
            padding: 0 15px;

        }

        .checkout-result-complete .checkout-order {
            background-color: transparent;
            padding: 25px 20px 15px 20px;
            padding: 1.5625rem 1.25rem 0.9375rem 1.25rem;
        }
    </style>
@endpush
