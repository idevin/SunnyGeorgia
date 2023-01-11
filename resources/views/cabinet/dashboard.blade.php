@extends('cabinet.layouts.app')

@section('content')
    <div class="m-grid__item m-grid__item--fluid m-wrapper">
        <!-- BEGIN: Subheader -->
        <div class="m-subheader ">
            <div class="d-flex align-items-center">
                <div class="mr-auto">
                    <h3 class="m-subheader__title ">
                        {{trans('cabinet/index.Dashboard')}}
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
                @if($user->hasRole('admin') && $toursForReview->isNotEmpty())
                    <div class="col-lg-6">
                        @include('cabinet.dashboard.tour_review')
                    </div>
                @endif
                @if($user->hasRole('partner'))
                    @include('cabinet.dashboard_partner')
                @endif

                @if(!$user->hasRole('partner'))
                    <div class="col-lg-6">
                        @include('cabinet.dashboard.become_partner')
                    </div>
                @endif


                <div class="col-lg-6">
                    <div class="m-portlet m-portlet--head-solid-bg">
                        <div class="m-portlet__head">
                            <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-title">
												<span class="m-portlet__head-icon">
													<i class="flaticon-user"></i>
												</span>
                                    <h3 class="m-portlet__head-text">
                                        Редактировать профиль
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <div class="m-portlet__body">
                            <a href="{{route('cabinet:profile.view')}}" class="btn btn-lg btn-primary">Редактировать
                                профиль</a>
                        </div>
                    </div>
                </div>


            </div>

        </div>
    </div>
@endsection