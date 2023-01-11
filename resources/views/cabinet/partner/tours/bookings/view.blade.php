@extends('cabinet.layouts.app')

@section('content')
    <div class="m-grid__item m-grid__item--fluid m-wrapper">
        <!-- BEGIN: Subheader -->
        <div class="m-subheader ">
            <div class="d-flex align-items-center">
                <div class="mr-auto">
                    <h3 class="m-subheader__title ">
                        {{trans('cabinet/index.Tour booking')}}
                    </h3>
                </div>
            </div>
        </div>
        <!-- END: Subheader -->
        <tour-booking
                form-role="partner"
                form-action="{{route('cabinet:partner:tours.booking.update', $booking->id) }}"
                :initial-booking="{{json_encode($booking)}}"
                :tour="{{json_encode($booking->tour)}}"
                tour-link="{{route('tours.view', ['tour' => $booking->tour->slug]) }}"
                :localization="{{json_encode(trans('cabinet/index')) }}"
        ></tour-booking>
    </div>
@endsection