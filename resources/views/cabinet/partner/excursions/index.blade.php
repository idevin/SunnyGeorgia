@extends('cabinet.layouts.app')

@section('content')
    <div class="m-grid__item m-grid__item--fluid m-wrapper">
        <!-- BEGIN: Subheader -->
        <div class="m-subheader ">
            <div class="d-flex align-items-center">
                <div class="mr-auto">
                    <h3 class="m-subheader__title ">
                        {{trans('cabinet/index.Excursions')}}
                    </h3>
                </div>

            </div>
        </div>
        <!-- END: Subheader -->
        <div class="m-content">
            <table-data
              route="{{route('cabinet:partner:excursions.index')}}"
              places_groups="{{$placesGroups}}"
              users="{{json_encode([$user])}}"
              :fields="{{$fields}}"
            ></table-data>
        </div>
    </div>
@endsection