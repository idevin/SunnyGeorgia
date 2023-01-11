@extends('cabinet.layouts.app')

@section('content')
    <div class="m-grid__item m-grid__item--fluid m-wrapper">
        <!-- BEGIN: Subheader -->
        <div class="m-subheader ">
            <div class="d-flex align-items-center">
                <div class="mr-auto">
                    <h3 class="m-subheader__title ">
                        Places
                    </h3>
                </div>

            </div>
        </div>
        <!-- END: Subheader -->
        <div class="m-content">
            <!--Begin::Main Portlet-->
            <div class="row">
                <div class="col-xl-12 col-lg-12">
                    <div class="m-portlet m-portlet--full-height m-portlet--tabs  ">

                        <div class="m-portlet__head">
                            <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-title">
                                    <h3 class="m-portlet__head-text">
                                        Place groups
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <div class="m-portlet__body">
                            <table class="table table-responsive">
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Places</th>
                                </tr>
                                @foreach($placesGroup as $item)
                                    <tr>
                                        <td>{{$item->id}}</td>
                                        <td>{{$item->name}}</td>
                                        <td>
                                            @foreach($item->places as $place)
                                                <a href="{{route('control:places.view', $place->id)}}">{{$place->name}}</a>
                                                |
                                            @endforeach
                                        </td>
                                    </tr>
                                    @if($loop->last)
                                        @foreach($places as $place)
                                            @if( ! $place->placesGroup)
                                            <tr>
                                                <td>--</td>
                                                <td>Без группы</td>
                                                <td>
                                                    <a href="{{route('control:places.view', $place->id)}}">{{$place->name}}</a>
                                                </td>
                                            </tr>
                                            @endif
                                        @endforeach
                                    @endif
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
@endsection
