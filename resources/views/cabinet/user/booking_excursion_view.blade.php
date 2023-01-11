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
        <div class="m-content">
            @if ($item->status == 'payed')
                <product-review
                        :product-id="{{$item->excursion->id}}"
                        product-type="excursion"
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
                                {{trans('cabinet/index.Excursion booking')}} #{{$item->id}}
                                <br>
                                <small>{{$item->created_at}}</small>
                            </h3>
                        </div>
                    </div>
                    @if($item->confirmed)
                        <div class="m-portlet__head-tools">
                            <ul class="m-portlet__nav">
                                <li class="m-portlet__nav-item">
                                    <i class="la la-check-circle" title="Подтвержден"></i>
                                </li>
                            </ul>
                        </div>
                    @endif
                </div>
                <div class="m-portlet__body">
                    <div class="row">
                        <div class="col-lg-8">
                            <a href="{{route('excursions.view', ['excursion' => $item->excursion->slug])}}"
                               target="_blank">
                                <h4 class="mb-3">
                                    {{$item->excursion->title}}
                                    <i class="fa fa-eye"></i>
                                </h4>
                            </a>

                            <div>
                                <div>
                                    @if ($item->group_pid)
                                        <ul class="list-group mb-3">
                                            <li class="list-group-item active"><h5 class="mb-0">Группа:</h5></li>
                                            <li class="list-group-item">От:
                                                <span class="badge badge-primary badge-pill">
                                                    {{$item->excursion->prices->firstWhere('id', $item->group_pid)['price_from']}}
                                                </span>
                                            </li>
                                            <li class="list-group-item">До:
                                                <span class="badge badge-primary badge-pill">
                                                    {{$item->excursion->prices->firstWhere('id', $item->group_pid)['price_to']}}
                                                </span>
                                            </li>
                                        </ul>
                                    @else
                                        <ul class="list-group mb-3">
                                            <li class="list-group-item active"><h5 class="mb-0">Участники:</h5></li>
                                            <li class="list-group-item">Взрослые: <span
                                                        class="badge badge-primary badge-pill">{{$item->qty_adults}}</span>
                                            </li>
                                            @if($item->qty_kids)

                                            <li class="list-group-item">Дети: <span
                                                        class="badge badge-primary badge-pill">{{$item->qty_kids}}</span>
                                            </li>
                                            @endif
                                            @if($item->qty_baby)
                                            <li class="list-group-item">Дети
                                                до {{$item->excursion->prices[1]['price_to']}}: <span
                                                        class="badge badge-primary badge-pill">{{$item->qty_baby}}</span>
                                            </li>
                                            @endif
                                            @if($item->qty_child)
                                            <li class="list-group-item">Дети
                                                до {{$item->excursion->prices[2]['price_to']}}: <span
                                                        class="badge badge-primary badge-pill">{{$item->qty_child}}</span>
                                            </li>
                                            @endif
                                        </ul>
                                    @endif
                                </div>
                                <div>
                                    <ul class="list-group mb-3">
                                        <li class="list-group-item active"><h5 class="mb-0">Статус:</h5></li>
                                        @if($item->status == 'confirmed')
                                            <li class="list-group-item"><span
                                                        class="badge badge-primary">Подтвержден</span>

                                                &nbsp;<a class="btn m-btn btn-success"
                                                         href="{{route('excursions.checkout1', ['id' => $item->id])}}"
                                                        {{$item->confirmed && $item->status != 'payed' ?'':'disabled'}}>Перейти
                                                    к оплате</a></li>
                                            {{--<a class="btn m-btn m-btn--icon m-btn--icon-only" {{$item->confirmed && $item->status != 'payed' ?'':'disabled'}}>PAY</a>--}}
                                        @elseif($item->status == 'created')
                                            <li class="list-group-item"><span class="badge badge-warning">Ожидаем подтверждение</span>
                                            </li>
                                        @elseif($item->status == 'payed')
                                            <li class="list-group-item">
                                                <span class="badge badge-success">Оплачено</span>&nbsp;
                                                <button class="btn btn-light " type="button" data-toggle="collapse"
                                                        data-target="#collapseCheck" aria-expanded="false"
                                                        aria-controls="collapseCheck">
                                                    Ваш чек-билет &nbsp;<i class="fa fa-chevron-down"></i>
                                                </button>


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
                            <p>Начало:</p>
                            <h3>{{$item->date_in->format('d')}} {{trans('date.months.'.$item->date_in->format('F'))}} {{$item->date_in->format('Y')}}
                                <br>{{$item->time_in}}</h3>

                            <br>
                            <table class="table">
                                <tr>
                                    <td>Стоимость:</td>
                                    <td align="right">
                                        <h4>
                                            <strong>{{currency($item->total, 'USD', currency()->getUserCurrency())}}
                                            </strong>
                                            <br>
                                            <small>({{number_format($item->total,2)}} USD)</small>
                                        </h4>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Предоплата:</td>
                                    <td align="right">
                                        <h4>
                                            <strong>{{currency($item->prepay, 'USD', currency()->getUserCurrency())}}
                                            </strong>
                                            <br>
                                            <small>({{number_format($item->prepay,2)}} USD)</small>
                                        </h4>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Доплата на месте:</td>
                                    <td align="right">
                                        <h4>
                                            <strong>{{currency($item->total - $item->prepay, 'USD', currency()->getUserCurrency())}}
                                            </strong>
                                            <br>
                                            <small>({{number_format($item->total - $item->prepay,2)}} USD)</small>
                                        </h4>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <excursion-order inline-template>
                        <div class="row">
                            <div class="col-lg">
                                @if($item->status != 'canceled')
                                    @if ((strtotime($item->date_time_in) - strtotime(date("Y-m-d H:i:s", time()))) > $item->excursion->free_cancel_before * 60 * 60)
                                        <button @click="activateModal = true"
                                           class="btn btn-danger"
                                        >Отменить бронирование</button>
                                        <strong>&nbsp;До {{date('d.m.Y H:i:s' ,strtotime($item->date_time_in) - ($item->excursion->free_cancel_before * 60 * 60))}}</strong>
                                    @endif
                                @endif
                            </div>

                           <confirm-booking-deletion
                             route="{{route('cabinet:orders.excursion_cancel', $item->id)}}"
                             :active="activateModal"
                             @close-modal="activateModal = false"
                           ></confirm-booking-deletion>
                        </div>
                    </excursion-order>
                    @if ($item->status == 'payed')
                        <div class="collapse list-group-item mb-3" id="collapseCheck">
                            @include("site.excursions.check_ticket", ["booking" => $item])
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
