@extends('cabinet.layouts.app')

@section('content')
    <div class="m-grid__item m-grid__item--fluid m-wrapper">
        <!-- BEGIN: Subheader -->
        <div class="m-subheader ">
            <div class="d-flex align-items-center">
                <div class="mr-auto">
                    <h3 class="m-subheader__title ">
                        {{trans('cabinet/index.Bank payments')}}
                    </h3>
                </div>

            </div>
        </div>
        <!-- END: Subheader -->
        <div class="m-content">
            {{$payments->links()}}
            <div class="m-portlet m-portlet--mobile">
                {{--<div class="m-portlet__body">--}}
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Service</th>
                            <th>Client</th>
                            <th>Partner</th>
                            <th>System</th>
                            <th>Amount</th>
                            <th>Currency</th>
                            <th>Status</th>
                            <th>Created</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($payments as $item)
                            <tr>
                                <td>{{$item->id}}</td>
                                <td>
                                    @if($item->service)
                                        @if($item->service instanceof \App\Models\Tours\TourBooking)
                                            <a href="{{route('control:tours.booking.view', $item->service->id)}}">#{{$item->service->id}}
                                                Tour Booking</a>
                                        @elseif($item->service instanceof \App\Models\Excursions\ExcursionBooking)
                                            <a href="{{route('control:excursions.booking.view', $item->service->id)}}">#{{$item->service->id}}
                                                Excursion Booking</a>
                                        @endif
                                    @else
                                        id: {{$item->service_id}}
                                        <small>{{$item->service_type}}</small>
                                    @endif
                                </td>
                                <td>
                                    @if($item->user)
                                        <a href="{{route('control:users.view', $item->user->id)}}">
                                            <small>id: {{$item->user->id}}</small>
                                        </a> {{$item->user->email}}
                                    @endif
                                </td>
                                <td>
                                    @if($item->service)

                                        @if($item->service instanceof \App\Models\Tours\TourBooking)
                                            @if($item->service->tour->partner)
                                                {{$item->service->tour->partner->llc}}
                                            @endif
                                        @elseif($item->service instanceof \App\Models\Excursions\ExcursionBooking)
                                            @if($item->service->excursion->partner)
                                                {{$item->service->excursion->partner->llc}}
                                            @endif
                                        @endif
                                    @endif
                                </td>
                                <td>{{$item->system}} id: <strong>{{$item->transaction_id}}</strong></td>
                                <td style="text-align: right">{{number_format($item->amount / 100, 2)}}</td>
                                <td>{{$item->currency_code}}</td>
                                <td>
                                    @switch($item->status)
                                        @case('created')
                                        <span class="m-badge m-badge--warning m-badge--wide">{{$item->status}}</span>
                                        @break
                                        @case('paid')
                                        @case('payed')
                                        <span class="m-badge m-badge--success m-badge--wide">{{$item->status}}</span>
                                        @break
                                        @default
                                        <span class="m-badge m-badge--default m-badge--wide">{{$item->status}}</span>
                                        @break
                                    @endswitch
                                </td>
                                <td>{{$item->created_at}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                {{--</div>--}}
            </div>
            {{$payments->links()}}
        </div>
    </div>
@endsection