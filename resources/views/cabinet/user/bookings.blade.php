@extends('cabinet.layouts.app')

@section('content')
    <div class="m-grid__item m-grid__item--fluid m-wrapper">
        <!-- BEGIN: Subheader -->
        <div class="m-subheader ">
            <div class="d-flex align-items-center">
                <div class="mr-auto">
                    <h3 class="m-subheader__title ">
                        Property
                    </h3>
                </div>

            </div>
        </div>
        <!-- END: Subheader -->
        <div class="m-content">


                <div class="row">
            @foreach($bookings as $item)
                    <div class="col-lg-6">
                        <div class="m-portlet">
                            <div class="m-portlet__head">
                                <div class="m-portlet__head-caption">
                                    <div class="m-portlet__head-title">
												<span class="m-portlet__head-icon">
													<i class="flaticon-map-location"></i>
												</span>
                                        <h3 class="m-portlet__head-text">
                                            Portlet Action Icons
                                        </h3>
                                    </div>
                                </div>
                                <div class="m-portlet__head-tools">
                                    <ul class="m-portlet__nav">
                                        <li class="m-portlet__nav-item">
                                            <a href="" class="m-portlet__nav-link m-portlet__nav-link--icon">
                                                <i class="la la-close"></i>
                                            </a>
                                        </li>
                                        <li class="m-portlet__nav-item">
                                            <a href="" class="m-portlet__nav-link m-portlet__nav-link--icon">
                                                <i class="la la-refresh"></i>
                                            </a>
                                        </li>
                                        <li class="m-portlet__nav-item">
                                            <a href="" class="m-portlet__nav-link m-portlet__nav-link--icon">
                                                <i class="la la-circle"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="m-portlet__body">
                                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled.
                            </div>
                        </div>
                    </div>
            @endforeach
                </div>
            <div class="m-portlet m-portlet--mobile">
                <div class="m-portlet__body">
                    <table class="m-datatable" id="html_table" width="100%">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Hotel</th>
                            <th>Rooms</th>
                            <th>Date IN</th>
                            <th>Date OUT</th>
                            <th>Tax</th>
                            <th>Total</th>
                            <th>Notes</th>
                            <th>Created at</th>
                        </tr>

                        </thead>

                        <tbody>
                        @foreach($bookings as $item)
                            <tr>
                                <td>{{$item->id}}</td>
                                <td>{{$item->hotel->title}}</td>
                                <td>
                                    @foreach($item->roomsBooking as $roomBook)
                                        {{--                                        {{$roomBook->room}}--}}
                                        <p>{{$roomBook->room->title or '(noname)'}}
                                            <span>${{number_format($roomBook->price_total, 2)}}</span></p>
                                    @endforeach
                                </td>
                                <td>{{$item->date_in->format('d M Y')}}</td>
                                <td>{{$item->date_out->format('d M Y')}}</td>
                                <td style="text-align: right" align="right">{{$item->tax_total}}</td>
                                <td align="right">{{$item->price_total}}</td>
                                <td>{{$item->notes}}</td>
                                <td>{{$item->created_at}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
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