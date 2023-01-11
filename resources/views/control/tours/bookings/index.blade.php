@extends('cabinet.layouts.app')

@section('content')
    <div class="m-grid__item m-grid__item--fluid m-wrapper">
        <!-- BEGIN: Subheader -->
        <div class="m-subheader ">
            <div class="d-flex align-items-center">
                <div class="mr-auto">
                    <h3 class="m-subheader__title ">
                        {{trans('cabinet/index.Tour bookings')}}
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
                        <th>id</th>
                        <th>Created</th>
                        <th>{{trans('cabinet/index.Tour')}}</th>
                        <th>{{trans('cabinet/index.Customer')}}</th>
                        <th>Date in</th>
                        <th>{{trans('cabinet/index.Confirmed')}}</th>
                        <th></th>
                    </tr>

                    </thead>

                    <tbody>
                    @foreach($bookings as $item)
                        <tr>
                            <td>{{$item->id}}</td>
                            <td>
                                <span class="m-badge badge-light badge-pill">{{$item->created_at}}</span>
                            </td>
                            <td>
                                @if($item->tour)
                                    <a href="{{route('control:tours.edit', $item->tour->id)}}">#{{$item->tour->id}}</a>
                                    {{str_limit($item->tour->title, 50)}}
                                @else
                                    <span class="small">#{{$item->tour_id}} lost in space... </span>
                                @endif
                            </td>
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
                            <td>
                                @include('layouts.status_layout',['status' => $item->status])
                            </td>
                            <td>
                                <a href="{{route('control:tours.booking.view', $item->id)}}"><i
                                            class="fa fa-eye"></i></a>
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