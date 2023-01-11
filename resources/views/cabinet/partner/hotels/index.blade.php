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
            <div class="m-portlet m-portlet--mobile">
                <div class="m-portlet__body">
                    <table class="m-datatable" id="html_table" width="100%">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Location</th>
                            <th>Title</th>
                            <th>Rooms</th>
                            <th>Published</th>
                            <th>Type</th>
                            <th>Created at</th>
                        </tr>

                        </thead>

                        <tbody>
                        @foreach($hotels as $item)
                            <tr>
                                <td>{{$item->id}}</td>
                                <td>
                                    @if($item->place)
                                        {{$item->place->name}}
                                    @endif
                                </td>
                                <td>{{$item->title}}
                                    @if($item->thumb)
                                        <img src="{{$item->thumb->url}}" alt="{{$item->thumb->url}}">
                                    @endif
                                </td>
                                <td>
                                    @foreach($item->rooms as $room)
                                        <p>{{$room->title}}</p>
                                    @endforeach
                                </td>
                                <td>
                                    @if($item->published)
                                        <span>Published</span>
                                    @endif
                                </td>
                                <td>{{$item->type}}</td>
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