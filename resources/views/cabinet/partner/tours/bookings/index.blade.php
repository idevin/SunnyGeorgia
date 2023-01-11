@extends('cabinet.layouts.app')

@section('content')
    <div class="m-grid__item m-grid__item--fluid m-wrapper">
        <!-- BEGIN: Subheader -->
        <div class="m-subheader ">
            <div class="d-flex align-items-center">
                <div class="mr-auto">
                    <h3 class="m-subheader__title ">
                        {{trans('cabinet/index.Tours')}}
                    </h3>
                </div>

            </div>
        </div>
        <!-- END: Subheader -->
        <div class="m-content">
            <div class="m-portlet m-portlet--mobile">
                {{--<div class="m-portlet__body">--}}
                <div class="table-responsive">
                    <table class="table datatable">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>{{trans('cabinet/index.Tour')}}</th>
{{--                            <th>{{trans('cabinet/index.Customer')}}</th>--}}
                            <th>Date in</th>
                            <th>{{trans('cabinet/index.Confirmed')}}</th>
                            <th></th>
                        </tr>

                        </thead>

                        <tbody>
                        @foreach($tourBooking as $item)
                            <tr>
                                <td>
                                    {{$item->id}} <span class="m-badge badge-light badge-pill">{{$item->created_at}}</span>
                                </td>
                                <td>#{{$item->tour->id}} {{str_limit($item->tour->title, 50)}}</td>
                                {{--<td>--}}
                                    {{--#{{$item->customer->id}}--}}
                                    {{--<strong>{{$item->customer->first_name or '-'}} {{$item->customer->last_name or '-'}}</strong>--}}
                                {{--</td>--}}
                                <td>{{$item->date_in->toDateString()}}</td>
                                <td>
                                    @include('layouts.status_layout', ['status' => $item->status])
                                </td>
                                <td>
                                    <a href="{{route('cabinet:partner:tours.booking.view', $item->id)}}"><i class="fa fa-eye"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                {{--</div>--}}
            </div>
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