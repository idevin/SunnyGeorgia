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
            <table-data route="{{route('cabinet:partner:tours.index')}}" places_groups="{{$placesGroups}}" users="{{json_encode([$user])}}" :fields="{{$fields}}"></table-data>
            {{--<div class="m-portlet m-portlet--mobile">
                --}}{{--<div class="m-portlet__body">--}}{{--
                    <table class="m-datatable" id="html_table" width="100%">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>thumb</th>
                            <th>{{trans('cabinet/index.Title')}}</th>
                            <th>{{trans('cabinet/index.Accommodations')}}</th>
                            --}}{{--                            <th>{{trans('cabinet/index.Published')}}</th>--}}{{--
                            <th></th>
                        </tr>

                        </thead>

                        <tbody>
                        @foreach($tours as $item)
                            <tr>
                                <td>
                                    {{$item->id}}
                                    <span class="text-light">{{$item->created_at}}</span>
                                    @if($item->published)
                                        <span class="badge badge-success">Опубликован</span>
                                    @else
                                        <span class="badge badge-warning">Не опубликован</span>
                                    @endif
                                    @if($item->reviewed)
                                        <span class="badge badge-success">Проверен</span>
                                    @else
                                        <span class="badge badge-warning">Не проверен</span>
                                    @endif
                                    @if($item->reviewed && $item->published)
                                        <span class="badge badge-success">Отображается</span>
                                    @else
                                        <span class="badge badge-primary">Скрыт</span>
                                    @endif
                                </td>
                                <td>
                                    @if($item->thumb)
                                        <img src="{{$item->thumb->url}}" alt="{{$item->thumb->name}}" class="thumbnail"
                                             style="max-width: 150px; max-height: 150px">
                                    @endif
                                </td>
                                <td>{{$item->title}}</td>
                                <td>
                                    @if(!empty($item->accommodations))
                                        <ul>
                                            @foreach($item->accommodations as $acom)
                                                <li>{{$acom->hotel}} {{$acom->room}}</li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </td>
                                --}}{{--<td>--}}{{--
                                --}}{{--@if($item->published)--}}{{--
                                --}}{{--<span>{{trans('cabinet/index.Published')}}</span>--}}{{--
                                --}}{{--@endif--}}{{--
                                --}}{{--</td>--}}{{--
                                <td>
                                    <a href="{{route('cabinet:partner:tours.edit', $item->id)}}"
                                       class="btn btn-default"><i class="fa fa-pencil-alt"></i></a>
                                    <a href="{{route('cabinet:partner:tours.accommodation', $item->id)}}"
                                       class="btn btn-default"><i class="fa fa-building"></i></a>
                                    <a href="{{route('cabinet:partner:tours.calendar', $item->id)}}"
                                       class="btn btn-default"><i class="fa fa-calendar-alt"></i></a>

                                    <a href="{{route('cabinet:partner:tours.delete', $item->id)}}"
                                       class="btn btn-default"
                                       onclick="event.preventDefault();
                                                     document.getElementById('delete-route-{{$item->id}}').submit();">
                                        <i class="fa fa-trash"></i>
                                    </a>

                                    <form id="delete-route-{{$item->id}}" action="{{route('cabinet:partner:tours.delete', $item->id)}}" method="POST"
                                          style="display: none;">
                                        @method('delete')
                                        @csrf
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                --}}{{--</div>--}}{{--
            </div>--}}
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
                    data: {
                        saveState: {
                            cookie: !0,
                            webstorage: !0
                        },
                    }
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