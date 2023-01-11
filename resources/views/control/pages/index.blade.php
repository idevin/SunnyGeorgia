@extends('cabinet.layouts.app')

@section('content')
    <div class="m-grid__item m-grid__item--fluid m-wrapper">
        <!-- BEGIN: Subheader -->
        <div class="m-subheader ">
            <div class="d-flex align-items-center">
                <div class="mr-auto">
                    <h3 class="m-subheader__title ">
                        Pages
                        <a href="{{route('control:pages.create')}}" class="btn btn-primary btn-sm">
                            <i class="fa fa-plus"></i>
                        </a>
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

                                    </h3>
                                </div>
                            </div>
                        </div>
                        <div class="m-portlet__body table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Name</th>
                                        <th>Route</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($pages as $item)
                                    <tr>
                                        <td>{{$item->id}}</td>
                                        <td> @if (isset($item->translations()->first()->name)){{$item->translations()->first()->name}} @endif</td>
                                        <td>
                                            {{$item->slug}}
                                        </td>
                                        <td class="text-right">
                                            <div class="btn-group">
                                                <a href="{{route('control:pages.edit', $item->id)}}" class="btn btn-default btn-sm mr-2">
                                                    <i class="fa fa-pencil-alt"></i>
                                                </a>
                                                <form action="{{route('control:pages.destroy', $item->id)}}" method="POST">
                                                    {{ method_field('DELETE') }}
                                                    {{ csrf_field() }}
                                                    <button class="btn btn-default btn-sm" type="submit">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>

                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection