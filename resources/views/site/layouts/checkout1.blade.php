@extends('site.layouts.new-app')

@push('header')
    <link rel="preload" href="{{ URL::asset(get_webpack_asset('information-pages-vendors.css')) }}" as="style">
    <link rel="stylesheet" href="{{ URL::asset(get_webpack_asset('information-pages-vendors.css')) }}">
    <link rel="stylesheet" href="{{ URL::asset(get_webpack_asset('information-pages.css')) }}">
@endpush

@section('content')
    <main class="page-main" id="excursion_checkout_1">
        <div class="container">
            <ul class="step list-unstyled mb-4">
                <li class="step-item active">
                    <span class="step-count">1</span>
                    <span class="step-text">{{trans('checkout.Order details')}}</span>
                </li>
                <li class="step-item">
                    <span class="step-count">2</span>
                    <span class="step-text">{{trans('checkout.Payment')}}</span>
                </li>
                <li class="step-item">
                    <span class="step-count">3</span>
                    <span class="step-text">{{trans('checkout.End of booking')}}</span>
                </li>
            </ul>
            <div class="row checkout mb-4">
                <div class="col-md-5 mt-md-0 mt-4">
                    <form action="{{route('excursions.checkout1_post', ['id' => $booking->id])}}"
                          method="post">
                        {!! csrf_field() !!}
                        <div class="checkout-form d-flex justify-content-center py-4">
                            <div class="px-4 mb-2">
                                <strong class="checkout-title">{{trans('checkout.Contacts and conditions')}}</strong>
                                <div class="form-group" style="font-weight: bold">
                                    <span class="mr-3">{{trans('checkout.Email')}}:</span> {{$booking->customer->email}}
                                </div>

                                <div class="form-group">
                                    <span class="mr-3">{{trans('checkout.Mobile number')}}:</span> {{$booking->customer->mobile_number}}
                                </div>
                                <hr>
                                <div class="custom-control-sm mb-5">{{trans(('checkout.Confirm payment text'))}}</div>

                                <div class="form-group mb-2">
                                    <div class="form-group d-flex">
                                        <label
                                                class="custom-control-label custom-control-sm d-flex mb-0"
                                                for="booking-validation"
                                        >
                                            <input
                                                    type="checkbox"
                                                    class="custom-control-input mr-2 cursor-pointer"
                                                    id="booking-validation"
                                                    required
                                                    style="height: 18px; flex: 0 0 6%;"
                                            >
                                            <span style="font-size: 13px"
                                                  class="flex-grow-1 cursor-pointer">{!! trans('checkout.Press the button to book') !!}</span>
                                        </label>

                                    </div>
                                </div>
                                <div class="form-group d-flex flex-column mb-5">
                                    <button class="btn btn-dark checkout-btn"
                                            type="submit"
                                    >
                                        {{trans('checkout.Pay now')}}
                                    </button>
                                </div>
                                <div class="form-group d-flex flex-column">
                                    <div class="d-flex justify-content-between">
                                        <span class="d-block mb-2">{{trans('checkout.We accept payment')}}:</span>
                                        <div class="d-flex checkout-providers justify-content-end">
                                            <div class="ml-2">
                                                <img src="/static/images/general/visa.svg" alt="Visa">
                                            </div>
                                            <div class="ml-2">
                                                <img src="/static/images/general/mastercard.svg" alt="Master Card">
                                            </div>
                                            <div>
                                                <img src="/static/images/general/american-express.svg"
                                                     alt="American Express">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-7 order-first order-md-last">
                    <div class="checkout-result checkout-result-complete py-4">
                        <strong class="checkout-title">{{trans('checkout.Your order details')}}:</strong>
                        @yield('booking_data')

                        <div class="row align-items-center mb-1">
                            <span class="col-6 checkout-order-text text-blue">{{trans('checkout.Order price')}}:</span>
                            <strong class="checkout-order-count text-blue">
                                {{money_view($booking->total + $booking->prepay * 0.024)}} {{$booking->currency_code}}
                            </strong>
                        </div>
                        <div class="row align-items-center mb-1">
                            <span class="col-6 checkout-order-text text-blue">{{trans('checkout.Prepayment')}}:</span>
                            <strong class="checkout-order-count text-blue">{{money_view($booking->prepay)}} {{$booking->currency_code}}</strong>
                        </div>

                        <div class="row align-items-center mb-1">
                            <span class="col-6 checkout-order-text small">{{trans('checkout.Transaction fee')}}:</span>
                            <strong class="checkout-order-count"
                                    style="font-size: 18px">{{money_view($booking->prepay * 0.024)}} {{$booking->currency_code}}</strong>
                        </div>
                        <div class="row align-items-center mb-4">
                            <span class="col-6 checkout-order-text small">{{trans('checkout.Extra charge on the spot')}}:</span>
                            <strong class="checkout-order-count"
                                    style="font-size: 18px">{{money_view($booking->total - $booking->prepay)}} {{$booking->currency_code}}</strong>
                        </div>


                        <div class="row align-items-center mb-2">
                            <span class="col-12 checkout-help">
                                {{$booking->created_at}}
                                <br>{{trans('checkout.Order number')}}: E000{{$booking->id}}
                            </span>
                            {{--<a href="#!" class="checkout-small text-dark">Изменить детали заказа</a>--}}
                        </div>
                        <div class="row align-items-center">
                            <div class="col-12">
                                <div class="checkout-help">
                                    <span class="text-danger">*</span>{{trans('checkout.Prepayment is a guarantee')}}
                                </div>
                                <div class="checkout-help">
                                    <span class="text-danger">*</span>{{trans('checkout.On-site surcharge part of the service fee')}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('scripts')
    <script type="text/javascript" src="{{ URL::asset(get_webpack_asset('information-pages-vendors.js')) }}"
            defer></script>
    <script type="text/javascript" src="{{ URL::asset(get_webpack_asset('information-pages.js')) }}" defer></script>
@endpush

@push('styles')
    <style>
        .checkout-form {
            border-radius: 10px;
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
            background: #ffd961;
            margin-top: 15px;
            border: none;
            font-size: 18px;
            color: #82723e;
            padding: 17px 50px;
            letter-spacing: 1px;
            border-radius: 3px;
            transition: all ease .3s;
            font-weight: bold;
            cursor: pointer;
        }

        .checkout-btn:hover {
            background: #eec64a;
        }

        .checkout-small {
            font-size: 12px;
            font-size: 0.75rem;
        }

        .checkout-list {
            margin-top: 15px;
            padding-left: 17px;
        }

        .checkout-list li {
            margin-bottom: 15px;
            width: 100%;
        }

        .checkout-list p {
            margin: 0;
            color: #000;
        }

        .checkout-list p:not(:last-child) {
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
            text-align: left;
        }

        .text-blue {
            color: #0e66ad !important;
        }

        .checkout-order-text.small {
            font-size: 13px;
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
        }
    </style>
@endpush
