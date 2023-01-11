@extends('cabinet.layouts.app')

@section('content')
    <div class="m-grid__item m-grid__item--fluid m-wrapper">
        <!-- BEGIN: Subheader -->
        <div class="m-subheader ">
            <div class="d-flex align-items-center">
                <div class="mr-auto">
                    <h3 class="m-subheader__title ">
                        {{trans('cabinet/index.Bookings')}}
                    </h3>
                </div>

            </div>
        </div>
        <!-- END: Subheader -->
        <div class="m-content">
            <div class="row">
                @foreach($orders as $order)
                    @if($order instanceof \App\Models\Tours\TourBooking)
                        @include('cabinet.user.booking_tour_block', $order)
                    @elseif($order instanceof \App\Models\Excursions\ExcursionBooking)
                        @include('cabinet.user.booking_excursion_block', $order)
                    @endif
                @endforeach
            </div>
        </div>
    </div>
@endsection