@extends('cabinet.layouts.app')

@section('content')
    <div class="m-grid__item m-grid__item--fluid m-wrapper">
        <!-- BEGIN: Subheader -->
        <div class="m-subheader ">
            <div class="d-flex align-items-center">
                <div class="mr-auto">
                    <h3 class="m-subheader__title ">
                        {{trans('cabinet/index.Options')}}
                    </h3>
                </div>
                <a href="{{route('control:options.create')}}" class="btn btn-primary">{{trans('cabinet/index.Add')}}</a>


            </div>
        </div>
        <!-- END: Subheader -->
        <div class="m-content">
            <!--Begin::Main Portlet-->
            <div class="row">
                <div class="col-xl-12 col-lg-12">
                    <div class="m-portlet m-portlet--full-height m-portlet--tabs  ">

                        {{--<div class="m-portlet__head">--}}
                            {{--<div class="m-portlet__head-caption">--}}
                                {{--<div class="m-portlet__head-title">--}}
                                    {{--<h3 class="m-portlet__head-text">--}}
                                        {{--Options--}}
                                    {{--</h3>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        <div class="m-portlet__body">
                            <ul>
                                @foreach($options as $item)
                                    <li>
                                        <p>
                                            <a href="{{route('control:options.edit', $item->id)}}">{{$item->id}} {{$item->title}}</a>
                                        </p>
                                        <ul>
                                            @foreach($item->options as $opItem)
                                                <li>{{$opItem->title}}</li>
                                            @endforeach
                                        </ul>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
@endsection
