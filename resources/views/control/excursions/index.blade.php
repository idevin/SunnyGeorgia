@extends('cabinet.layouts.app')

@section('content')
    <div class="m-grid__item m-grid__item--fluid m-grid m-grid--hor">
        <!-- BEGIN: Subheader -->
        <div class="m-subheader  m-grid__item" id="m_subheader">
            <div class="m-subheader__title">
                <h3 class="m-subheader__title ">
                    {{trans('cabinet/index.Excursions')}}
                </h3>
            </div>
        </div>
        <!-- END: Subheader -->
        <div class="m-content  m-grid__item m-grid__item--fluid" id="m-content">
            <table-data route="{{route('control:excursions.index')}}"
                        places_groups="{{$placesGroups}}"
                        users="{{$users}}"
                        :fields="{{$fields}}"
            ></table-data>
        </div>
    </div>
@endsection
