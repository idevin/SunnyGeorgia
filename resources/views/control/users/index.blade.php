@extends('cabinet.layouts.app')

@section('content')
    <div class="m-grid__item m-grid__item--fluid m-wrapper">
        <!-- BEGIN: Subheader -->
        <div class="m-subheader ">
            <div class="d-flex align-items-center">
                <div class="mr-auto">
                    <h3 class="m-subheader__title ">
                        {{trans('cabinet/index.Users')}}
                    </h3>
                </div>

            </div>
        </div>
        <!-- END: Subheader -->
        <div class="m-content">
            <!--Begin::Main Portlet-->
            <div class="row">
                <div class="col-xl-12 col-lg-12">
                    {{$users->links()}}
                    <div class="m-portlet m-portlet--tabs  ">

                        {{--<div class="m-portlet__head">--}}
                            {{--<div class="m-portlet__head-caption">--}}
                                {{--<div class="m-portlet__head-title">--}}
                                    {{--<h3 class="m-portlet__head-text">--}}
                                        {{--Users--}}
                                    {{--</h3>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="m-portlet__body">--}}
                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <th>ID</th>
                                    <th>{{trans('cabinet/index.Name')}}</th>
                                    <th>Email</th>
                                    <th>Roles</th>
                                    <th></th>
                                </tr>
                                @foreach($users as $item)
                                    <tr>
                                        <td>{{$item->id}}</td>
                                        <td>
                                            <h5>{{$item->first_name}} {{$item->last_name}}</h5>

                                        </td>
                                        <td>{{$item->email}}
                                            @if($item->email_verified)
                                                <i class="fa fa-check-circle-o m--font-success"></i>
                                            @endif
                                        </td>
                                        <td>
                                            @foreach($roles as $role)
                                                <span class="m-badge  m-badge--wide {{$item->roles->contains($role->id) ? 'm-badge--brand' : 'm-badge--metal'}}">{{$role->name}}</span>
                                            @endforeach
                                        </td>
                                        <td>
                                            @include('control.users.block_buttons', ['user' => $item])
                                            {{--<a href="{{route('control:users.view', $item->id)}}"><i--}}
                                                        {{--class="fa fa-eye"></i></a>--}}
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                        {{--</div>--}}
                    </div>
                    {{$users->links()}}
                </div>

            </div>

        </div>
    </div>
@endsection