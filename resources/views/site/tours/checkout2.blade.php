@extends('site.layouts.new-app')

@push('header')
    <link rel="preload" href="{{ URL::asset(get_webpack_asset('information-pages-vendors.css')) }}" as="style">
    <link rel="stylesheet" href="{{ URL::asset(get_webpack_asset('information-pages-vendors.css')) }}">
    <link rel="stylesheet" href="{{ URL::asset(get_webpack_asset('information-pages.css')) }}">
    <link rel="stylesheet" href="{{ URL::asset('legacy.css') }}">
@endpush

@section('content')
    <main class="page-main" id="tour_checkout_2">
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
            <div class="row checkout">
                <div class="col-md-6">
                    <div class="checkout-form d-flex justify-content-center py-4">
                        <div class="px-4">
                            <strong class="checkout-title">{{trans('checkout.Your data')}}</strong>

                            <div class="checkout-contacts">
                                <p class="checkout-text">{{trans('checkout.Detailed booking details are available in your office in the bookings section.')}}</p>
                                <p class="checkout-text">{{trans('checkout.A confirmation of the successful booking has been sent to your email address.')}}</p>
                            </div>
                            <div class="checkout-contacts">
                                <div class="checkout-user">
                                    <h2>{{trans('checkout.Buyer')}}:</h2>
                                    <ul class="list-unstyled">
                                        <li><span>{{trans('checkout.Name')}}:</span> <strong>{{$user->first_name or '-'}}</strong></li>
                                        <li><span>{{trans('checkout.Lastname')}}:</span> <strong>{{$user->last_name or '-'}}</strong></li>
                                        <li><span>{{trans('checkout.Email')}}:</span> <strong>{{$user->email}}</strong></li>
                                        <li><span>{{trans('checkout.Phone')}}:</span> <strong>{{$user->mobile_number}}</strong></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="checkout-contacts">
                                <h2>{{trans('checkout.Contact details of the service provider')}}</h2>
                                <ul class="list-unstyled">
                                    <li>
                                        <span>{{trans('checkout.Tour Operator')}}:</span>
                                        @if($tourPartner->llc)
                                            <strong>{{$tourPartner->llc}}</strong>
                                        @else
                                            {{$tourUser->first_name}} {{$tourUser->last_name}}
                                        @endif
                                    </li>
                                    <li>
                                        <span>{{trans('checkout.Address')}}:</span>
                                        <strong>{{$tourPartner->country}} {{$tourPartner->city}} {{$tourPartner->postcode}}
                                            {{$tourPartner->address1}} {{$tourPartner->address2}} </strong>
                                    </li>
                                    <li>
                                        <span>{{trans('checkout.Tel')}}:</span>
                                        <strong>
                                            @if($tourPartner->phone)
                                                <span>{{$tourPartner->phone}}</span>
                                            @else
                                                <span>{{$tourUser->mobile_number}}</span>
                                            @endif
                                        </strong>
                                    </li>
                                </ul>
                                <p>{{trans('checkout.Free cancellation is possible until')}}
                                    <span class="text-danger">{{$booking->date_in->subDays($tour->free_cancel_before)->format('d-m-Y')}}</span>.
                                    {{trans('checkout.If you cancel after the specified date, the cancellation fee will be')}}
                                    <span class="text-danger">{{$booking->prepay}} {{$booking->currency_code}}</span> ({{trans('checkout.Prepayment amount')}})
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 order-first order-md-last">
                    <div class="checkout-result checkout-result-complete py-4 px-4">
                        <strong class="checkout-title">{{trans('checkout.Your order details')}}:</strong>
                        <strong class="text-black">{{trans('checkout.Tour')}} &laquo;{{$tour->title}}&raquo;</strong>
                        <ul class="list-unstyled checkout-list">
                            <li>
                                <strong>{{trans('checkout.Place of start of the tour')}}:</strong>
                                <div>
                                    <p>{{$tour->place->name}}</p>
                                </div>
                            </li>
                            <li>
                                <strong>{{trans('checkout.The participants')}}:</strong>
                                <div>
                                    <p>{{trans('checkout.Adults')}}: {{$booking->qty_adults}}</p>
                                    <p>{{trans('checkout.Kids')}}: {{$booking->qty_kids}}</p>
                                </div>
                            </li>
                            <li>
                                <strong>{{trans('checkout.Start of the tour')}}:</strong>
                                <div>
                                    <p class="font-weight-bold">{{$booking->date_in->format('d')}} {{trans('date.months.'.$booking->date_in->format('F'))}} {{$booking->date_in->format('Y')}}</p>
                                </div>
                            </li>
                            <li>
                                <strong>{{trans('checkout.Duration')}}:</strong>
                                <div>
                                    <p class="font-weight-bold">{{$tour->days}} {{trans('checkout.days')}} / {{$tour->nights}} {{trans('checkout.nights')}}</p>
                                </div>
                            </li>
                            <li>
                                <strong>{{trans('checkout.Transfer')}}:</strong>
                                <div>
                                    @if($tour->transfer_included)
                                        <p>{{trans('checkout.included')}}</p>
                                    @else
                                        @if($booking->add_transfer)
                                            <p>{{trans('checkout.Added')}} {{$booking->transfer_cost}}</p>
                                        @else
                                            {{trans('checkout.not included')}}
                                        @endif
                                    @endif
                                </div>
                            </li>
                            <li>
                                @if($booking->food)
                                    <strong>{{trans('checkout.Food')}}:</strong>
                                    <div>
                                        <p>
                                            {{$booking->food->title}}<br>
                                            @if($booking->food_option_cost)
                                                <b>{{trans('checkout.Price')}} - {{number_format($booking->food_option_cost, 2)}} {{$booking->currency_code}}</b>
                                            @endif
                                        </p>
                                    </div>
                                @endif
                            </li>
                            <li>
                                <strong>{{trans('checkout.Accommodation conditions')}}:</strong>
                                <div>
                                    @foreach($booking->accommodationBooking as $acom)
                                        <p>
                                            {{$acom->accommodation->hotel}}<br>
                                            {{$acom->accommodation->room}}<br>
                                            @if($acom->qty_adults) {{trans('checkout.Adults')}} - {{$acom->qty_adults}} @endif
                                            @if($acom->qty_kids) {{trans('checkout.Kids')}} - {{$acom->qty_kids}} @endif

                                        </p>
                                    @endforeach
                                </div>
                            </li>
                        </ul>
                        <div class="d-flex justify-content-between align-items-end mb-3">
                            <span class="checkout-help">{{$booking->created_at}}
                                <br>{{trans('checkout.Order number')}}: Т000{{$booking->id}}</span>
                        </div>
                        <div class="checkout-order">
                            <div class="row align-items-center">
                                <div class="col-xl-4">
                                    <span class="checkout-order-text">{{trans('checkout.Order price')}}:</span>
                                    <span class="checkout-order-days">
                                        {{trans('checkout.for')}} {{$tour->days}} {{trans('checkout.days')}} / {{$tour->nights}}
                                        {{trans('checkout.nights')}}
                                    </span>
                                </div>
                                <div class="col-xl-8">
                                    <div class="d-flex justify-content-xl-end justify-content-around">
                                        <div class="text-right mr-xl-3">
                                            <span class="checkout-order-label text-success">{{trans('checkout.Already paid')}}:</span>
                                            <strong class="checkout-order-count text-success">
                                                {{money_view($booking->prepay)}} {{$booking->currency_code}}
                                            </strong>
                                        </div>
                                        <div class="text-right">
                                            <span class="checkout-order-label text-success">{{trans('checkout.Transaction fee')}}:</span>
                                            <strong class="checkout-order-count text-success">
                                                {{money_view($booking->prepay * 0.024)}} {{$booking->currency_code}}
                                            </strong>
                                        </div>
                                    </div>
                                    <div class="checkout-order-sum text-right">
                                        <span class="checkout-order-label">{{trans('checkout.Extra charge on the spot')}}:</span>
                                        <strong class="checkout-order-count">
                                            {{money_view($booking->total - $booking->prepay)}} {{$booking->currency_code}}
                                        </strong>
                                    </div>
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
