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
        <div class="m-content">
            @if ($item->status == 'payed')
                <product-review
                        :product-id="{{$item->tour->id}}"
                        product-type="tour"
                        @if($review)
                        :review-data="{{$review}}"
                        @endif
                ></product-review>
            @endif
            <div class="m-portlet m-portlet--head-solid-bg
                        @switch($item->status)
            @case('created')
                    m-portlet--warning
@break
            @case('confirmed')
                    m-portlet--primary
@break
            @case('payed')
                    m-portlet--success
@break
            @endswitch
                    ">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
												<span class="m-portlet__head-icon">
													<i class="flaticon-map-location"></i>
												</span>
                            <h3 class="m-portlet__head-text">
                                {{trans('cabinet/index.Tour booking')}} #{{$item->id}}
                                <br>
                                <small>{{$item->created_at}}</small>
                            </h3>
                        </div>
                    </div>
                    @if($item->confirmed)
                        <div class="m-portlet__head-tools">
                            <ul class="m-portlet__nav">
                                <li class="m-portlet__nav-item">
                                    <i class="la la-check-circle" title="??????????????????????"></i>
                                </li>
                            </ul>
                        </div>
                    @endif
                </div>
                <div class="m-portlet__body">
                    <div class="row">
                        <div class="col-lg-8">
                            <h4 class="mb-3">
                                @if($item->tour)
                                    {{str_limit($item->tour->title, 200)}}
                                    <span class="badge badge-light">
                                            {{-- todo ?????????????????? ???????? --}}
                                            <a href="{{route('tours.view', ['locale' => $user->locale, 'tour' => $item->tour->slug])}}"
                                               target="_blank">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                        </span>
                                @else
                                    ...
                                @endif
                            </h4>
                            <div>
                                <div>
                                    <ul class="list-group mb-3">
                                        <li class="list-group-item active"><h5 class="mb-0">????????????????????:</h5>
                                        </li>
                                        @foreach($item->accommodationBooking as $accommodation)
                                            <li class="list-group-item">
                                                <p class="font-weight-bold">
                                                    {{$accommodation->accommodation->hotel}}
                                                    <span class="font-weight-normal">({{$accommodation->accommodation->room}}
                                                                )</span>
                                                </p>
                                                <ul>
                                                    <li>????????????????: <span
                                                                class="badge badge-primary badge-pill">{{$accommodation->qty_adults}}</span>
                                                    </li>
                                                    <li>????????: <span
                                                                class="badge badge-primary badge-pill">{{$accommodation->qty_kids}}</span>
                                                    </li>
                                                    <li>????????????????????????????
                                                        ????????????????????: <span
                                                                class="badge badge-primary badge-pill">{{$accommodation->qty_additional}}</span>
                                                    </li>
                                                </ul>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div>
                                    <ul class="list-group mb-3">
                                        <li class="list-group-item active"><h5 class="mb-0">??????????????????:</h5></li>
                                        @if($item->guests->isNotEmpty())
                                            @foreach($item->guests as $guest)
                                                <li class="list-group-item">{{$guest->first_name}} {{$guest->last_name}}
                                                    @if($guest->child)
                                                        <i class="fa fa-child"></i>
                                                    @endif
                                                </li>
                                            @endforeach
                                        @else
                                            <li class="list-group-item">
                                                <span class="font-weight-bold">???????????? (?????????? ???????????????? ?????? ???????????????? ?????????? ?????????????????????????? ????????)</span>
                                            </li>
                                        @endif
                                        <li class="list-group-item">????????????????: <span
                                                    class="badge badge-primary badge-pill">{{$item->qty_adults}}</span>
                                        </li>
                                        <li class="list-group-item">????????: <span
                                                    class="badge badge-primary badge-pill">{{$item->qty_kids}}</span>
                                        </li>
                                        <li class="list-group-item">???????????????????????????? ????????????????????: <span
                                                    class="badge badge-primary badge-pill">{{$item->qty_additional}}</span>
                                        </li>
                                    </ul>
                                </div>
                                <div>
                                    <ul class="list-group mb-3">
                                        <li class="list-group-item active"><h5 class="mb-0">????????????????:</h5></li>
                                        <li class="list-group-item">
                                            @if($item->add_transfer)
                                                ?????????????? ?? ??????????????????
                                            @elseif($item->transfer_cost)
                                                {{currency($item->transfer_cost, $item->currency_code)}}
                                            @else
                                                ???? ??????????????
                                            @endif
                                        </li>
                                    </ul>
                                </div>
                                <div>
                                    <ul class="list-group mb-3">
                                        <li class="list-group-item active"><h5 class="mb-0">??????????????:</h5></li>
                                        <li class="list-group-item">
                                            @if($item->add_flight)
                                                ?????????????? ?? ??????????????????
                                            @elseif($item->flight_cost)
                                                {{currency($item->flight_cost, $item->currency_code)}}
                                            @else
                                                ???? ??????????????
                                            @endif
                                        </li>
                                    </ul>
                                </div>
                                <div>
                                    <ul class="list-group mb-3">
                                        <li class="list-group-item active"><h5 class="mb-0">??????????????:</h5></li>
                                        @if($item->food_option_id)
                                            @if($item->food)
                                                <li class="list-group-item">
                                                    {{$item->food->title}}
                                                    @if($item->food_option_cost)
                                                        <span class="badge badge-primary badge-pill">{{currency($item->food_option_cost, $item->currency_code)}}</span>
                                                    @endif
                                                </li>
                                            @else
                                                ...
                                            @endif
                                        @else
                                            <li class="list-group-item">???? ????????????????</li>
                                        @endif
                                    </ul>
                                </div>
                                <div>
                                    <ul class="list-group mb-3">
                                        <li class="list-group-item active"><h5 class="mb-0">????????????:</h5></li>
                                        @if($item->status == 'confirmed')
                                            <li class="list-group-item"><span class="badge badge-primary">??????????????????????</span>

                                                &nbsp;<a class="btn m-btn btn-success"
                                                         href="{{route('tours.checkout1', ['id' => $item->id])}}"
                                                        {{$item->confirmed && $item->status != 'payed' ?'':'disabled'}}>??????????????
                                                    ?? ????????????</a></li>
                                            {{--<a class="btn m-btn m-btn--icon m-btn--icon-only" {{$item->confirmed && $item->status != 'payed' ?'':'disabled'}}>PAY</a>--}}
                                        @elseif($item->status == 'created')
                                            <li class="list-group-item"><span class="badge badge-warning">?????????????? ??????????????????????????</span>
                                            </li>
                                        @elseif($item->status == 'payed')
                                            <li class="list-group-item"><span class="badge badge-success">????????????????</span>
                                            </li>
                                        @elseif($item->status == 'canceled')
                                            <li class="list-group-item"><span
                                                        class="badge badge-info">{{trans('cabinet/index.Canceled')}}</span>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <p>????????????:</p>
                            <h3>{{$item->date_in->format('d')}} {{trans('date.months.'.$item->date_in->format('F'))}} {{$item->date_in->format('Y')}}</h3>
                            <br>
                            <table class="table">
                                <tr>
                                    <td>??????????????????:</td>
                                    <td align="right"><h4>
                                            <strong>{{currency($item->total, $item->currency_code)}} <small>({{number_format($item->total,2)}}&nbsp{{$item->currency_code}})</small></strong>
                                        </h4></td>
                                </tr>
                                <tr>
                                    <td>????????????????????:</td>
                                    <td align="right"><h4>
                                            <strong>{{currency($item->prepay, $item->currency_code)}} <small>({{number_format($item->prepay, 2)}}&nbsp{{$item->currency_code}})</small></strong>
                                        </h4></td>
                                </tr>
                                <tr>
                                    <td>?????????????? ???? ??????????:</td>
                                    <td align="right"><h4>
                                            <strong>{{currency($item->total - $item->prepay, $item->currency_code)}} <small>({{number_format($item->total - $item->prepay, 2)}}&nbsp{{$item->currency_code}})</small></strong>
                                        </h4></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <tour-order inline-template>
                        <div class="row">
                            <div class="col-lg">
                                @if($item->status != 'canceled')
                                    <button @click="activateModal = true"
                                       class="btn btn-danger">????????????????
                                        ????????????????????????</button>
                                    <confirm-booking-deletion
                                      route="{{route('cabinet:orders.tour_cancel', $item->id)}}"
                                      :active="activateModal"
                                      @close-modal="activateModal = false"
                                    ></confirm-booking-deletion>
                                @endif
                            </div>
                        </div>
                    </tour-order>
                </div>
            </div>
        </div>
    </div>
@endsection
