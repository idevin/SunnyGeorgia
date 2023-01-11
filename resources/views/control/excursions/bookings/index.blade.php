@extends('cabinet.layouts.app')

@section('content')
    <div class="m-grid__item m-grid__item--fluid m-wrapper">
        <!-- BEGIN: Subheader -->
        <div class="m-subheader ">
            <div class="d-flex align-items-center">
                <div class="mr-auto">
                    <h3 class="m-subheader__title ">
                        {{trans('cabinet/index.Excursion bookings')}}
                    </h3>
                </div>

            </div>
        </div>
        <!-- END: Subheader -->
        <div class="m-content">
            {{$bookings->links()}}
            <div class="m-portlet m-portlet--mobile">
                {{--<div class="m-portlet__body">--}}
                <div class="table-responsive">
                    <table class="table datatable">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Partner</th>
                            <th>{{trans('cabinet/index.Excursion')}}</th>
                            <th>{{trans('cabinet/index.Customer')}}</th>
                            <th>Date in</th>
                            <th>Time in</th>
                            <th>{{trans('cabinet/index.Status')}}</th>
                            <th>Prepay</th>
                            <th></th>
                        </tr>

                        </thead>

                        <tbody>
                        @foreach($bookings as $item)
                            <tr>
                                <td>
                                    {{$item->id}} <span class="m-badge badge-light badge-pill">{{$item->created_at}}</span>
                                </td>
                                <td>
                                    @if($item->excursion)
                                        @if($item->excursion->partner)
                                            <a href="{{route('control:users.view', $item->excursion->user->id)}}"
                                               title="">#{{$item->excursion->partner->id}}</a>
                                                <br>{{$item->excursion->partner->llc}}
                                                <br>{{$item->excursion->partner->email}}

                                        @endif
                                    @endif
                                </td>
                                <td><a href="{{route('control:excursions.edit', ['excursion' => $item->excursion->id])}}">#{{$item->excursion->id}} {{str_limit($item->excursion->title, 20)}}</a></td>
                                <td>
                                    @if($item->customer)
                                        <a href="{{route('control:users.view', $item->customer->id)}}">#{{$item->customer->id}}</a>
                                        <strong>{{$item->customer->first_name}} {{$item->customer->last_name}}</strong>
                                        <br>{{$item->customer->email}}
                                    @else
                                        <span class="small">#{{$item->customer_id}} lost in space... </span>
                                    @endif
                                </td>
                                <td>{{$item->date_in->toDateString()}}</td>
                                <td>{{$item->time_in}}</td>
                                <td>
                                    @include('layouts.status_layout',['status' => $item->status])
                                </td>
                                <td style="text-align: right; {{$item->status=='payed' ? 'color: green; font-weight: bold':''}}">{{number_format($item->prepay, 2)}} {{$item->currency_code}} </td>
                                <td>
                                    <a href="{{route('control:excursions.booking.view', $item->id)}}"><i class="fa fa-eye"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                {{--</div>--}}
            </div>
            {{$bookings->links()}}
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        //== Class definition

        var DatatableHtmlTableDemo = function () {
            //== Private functions

            // demo initializer
            var demo = function () {

                var datatable = $('.m-datatable').mDatatable({
//                    search: {
//                        input: $('#generalSearch'),
//                    },
                });
            };

            return {
                //== Public functions
                init: function () {
                    // init dmeo
                    demo();
                },
            };
        }();

        jQuery(document).ready(function () {
            DatatableHtmlTableDemo.init();
        });
    </script>
@endpush