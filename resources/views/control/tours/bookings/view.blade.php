@extends('cabinet.layouts.app')

@section('content')
    <div class="m-grid__item m-grid__item--fluid m-wrapper">
        <!-- BEGIN: Subheader -->
        <div class="m-subheader ">
            <div class="d-flex align-items-center">
                <div class="mr-auto">
                    <h3 class="m-subheader__title ">
                        Tour Booking
                    </h3>
                </div>
            </div>
        </div>
        <!-- END: Subheader -->
        <tour-booking
                form-role="control"
                form-action="{{ route('control:tours.booking.update', $booking->id) }}"
                :initial-booking="{{$booking}}"
                :tour="{{$booking->tour}}"
                tour-link="{{  route('tours.view', ['locale'=> 'ru', 'tour' => $tour->slug]) }}"
                customer-link="{{ route('control:users.view', $booking->customer ? $booking->customer->id : '') }}"
                partner-link="{{ route('control:users.view', $tour->partner ? $tour->partner->id : 0) }}"
                user-link="{{ route('control:users.view', $tour->user->id) }}"
                :localization="{{json_encode(trans('cabinet/index')) }}"
        ></tour-booking>
    </div>
@endsection
