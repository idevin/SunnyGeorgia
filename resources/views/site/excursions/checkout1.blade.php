@extends('site.layouts.checkout1')
@section('booking_data')
    <strong class="text-black">{{trans('checkout.Excursion')}}  &laquo;{{$booking->excursion->title}}&raquo;</strong>
    <ul class="row checkout-list">
        <li>
            <strong>{{trans('checkout.Place of start of the excursion')}}:</strong>
            <div>
                <p>{{$booking->excursion->place->name}}</p>
                <p>{{$booking->excursion->start_place}}</p>

                @if($booking->excursion->lat && $booking->excursion->long)
                    <a href="https://www.google.com/maps/?q={{$booking->excursion->lat}},{{$booking->excursion->long}}"
                       class="btn btn-success btn-sm"
                       target="_blank">Посмотреть на карте</a>
                @endif
            </div>
        </li>
        <li>
            <strong>{{trans('checkout.The participants')}}:</strong>
            @if($booking->excursion->type == 'person')
                <div>
                    <p>{{trans('checkout.Adults')}}: {{$booking->qty_adults}}</p>
                    @if($booking->qty_kids)
                        <p>{{trans('checkout.Kids')}}: {{$booking->qty_kids}}</p>
                    @endif
                </div>
            @else
                <div>
                    <p>Группа
                        {{$booking->excursion->prices->firstWhere('id', $booking->group_pid)['price_from']}}
                        -
                        {{$booking->excursion->prices->firstWhere('id', $booking->group_pid)->price_to}}
                        человек
                    </p>
                </div>
            @endif
        </li>
        <li>
            <strong>{{trans('checkout.Start of the excursion')}}:</strong>
            <div>
                <p class="font-weight-bold">{{$booking->date_in->format('d')}} {{trans('date.months.'.$booking->date_in->format('F'))}} {{$booking->date_in->format('Y')}}
                    <br>
                    {{substr($booking->time_in, 0, -3)}}
                </p>
            </div>
        </li>
        <li>
            <strong>{{trans('checkout.Duration')}}:</strong>
            <div>
                <p class="font-weight-bold">{{intval($booking->excursion->duration / 24)}}
                    {{trans('checkout.days')}} / {{$booking->excursion->duration % 24 }}
                    {{trans('checkout.hours')}}</p>
            </div>
        </li>
    </ul>
@endsection
