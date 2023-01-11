@extends('site.layouts.checkout1')
@section('booking_data')
    <strong class="text-black">{{trans('checkout.Tour')}} &laquo;{{$booking->tour->title}}&raquo;</strong>
    <ul class="row checkout-list">
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
                @if($booking->qty_kids)
                    <p>{{trans('checkout.Kids')}}: {{$booking->qty_kids}}</p>
                @endif
                @if($booking->qty_additional)
                    <p>{{trans('checkout.Additionally')}}: {{$booking->qty_additional}}</p>
                @endif
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
                <p class="font-weight-bold">{{$tour->days}} {{trans('checkout.days')}}
                    / {{$tour->nights}} {{trans('checkout.nights')}}</p>
            </div>
        </li>
        <li>
            <strong>{{trans('checkout.End of the tour')}}:</strong>
            <div>
                <p class="font-weight-bold">{{$booking->date_in->addDays($tour->days)->format('d')}} {{trans('date.months.'.$booking->date_in->addDays($tour->days)->format('F'))}} {{$booking->date_in->addDays($tour->days)->format('Y')}}</p>
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
                            <b>{{trans('checkout.Price')}}
                                - {{number_format($booking->food_option_cost, 2)}} {{$booking->currency_code}}</b>
                        @endif
                    </p>
                </div>
            @endif
        </li>
        @if($booking->accommodationBooking && $booking->accommodationBooking->count())
            <li>
                <strong>{{trans('checkout.Accommodation conditions')}}:</strong>
                <div>
                    @foreach($booking->accommodationBooking as $acom)
                        <p>
                            {{$acom->accommodation->hotel}}<br>
                            {{$acom->accommodation->room}}<br>
                            @if($acom->qty_adults)
                                {{trans('checkout.Adults')}} - {{$acom->qty_adults}}
                            @endif
                            @if($acom->qty_kids)
                                {{trans('checkout.Kids')}} - {{$acom->qty_kids}}
                            @endif
                            @if($acom->qty_additional)
                                {{trans('checkout.Additional accommodation')}}
                                - {{$acom->qty_additional}}
                            @endif
                        </p>
                    @endforeach
                </div>
            </li>
        @endif
    </ul>
@endsection
