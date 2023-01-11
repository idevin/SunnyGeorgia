@extends('cabinet.layouts.app')

@section('content')
    <div class="m-grid__item m-grid__item--fluid m-wrapper">
        <!-- BEGIN: Subheader -->
        <div class="m-subheader ">
            <div class="d-flex align-items-center">
                <div class="mr-auto">
                    <h3 class="m-subheader__title ">
                        {{trans('cabinet/index.Excursion booking')}}
                    </h3>
                </div>
            </div>
        </div>
        <!-- END: Subheader -->
        <excursion-booking
                form-role="partner"
                form-action="{{route('control:excursions.booking.update', $booking->id) }}"
                :initial-booking="{{json_encode($booking)}}"
                :excursion="{{json_encode($booking->excursion)}}"
                excursion-link="{{route('excursions.view', ['excursion' => $booking->excursion->slug]) }}"
                :localization="{{json_encode(trans('cabinet/index'))}}"
        ></excursion-booking>
    </div>
@endsection