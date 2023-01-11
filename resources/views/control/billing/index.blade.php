@extends('cabinet.layouts.app')

@section('content')
    <div class="m-grid__item m-grid__item--fluid m-wrapper">
        <!-- BEGIN: Subheader -->
        <div class="m-subheader ">
            <div class="d-flex align-items-center">
                <div class="mr-auto">
                    <h3 class="m-subheader__title ">
                        Billing
                    </h3>
                </div>

                <a href="{{route('control:billing.export')}}" class="btn btn-primary"><i class="fa fa-file-excel"></i>
                    Export to Excel</a>
            </div>
        </div>
        <!-- END: Subheader -->
        <div class="m-content">
            <div class="m-portlet m-portlet--mobile">
                {{--<div class="m-portlet__body">--}}
                <div class="table-responsive">
                    @include('control.billing.table')
                </div>
                {{--</div>--}}
            </div>
        </div>
    </div>
@endsection