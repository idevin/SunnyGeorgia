<div class="col-lg-12">
    <div class="m-portlet m-portlet--head-solid-bg
        @switch($order->status)
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
                        Бронирование тура #{{$order->id}}<small>{{$order->created_at}}</small>
                    </h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                <ul class="m-portlet__nav">
                    @if($order->status == 'confirmed')
                        <li class="m-portlet__nav-item">
                            <span class="m-portlet__head-icon btn-lg">
                                <i class="la la-3x la-thumbs-up"></i>
                            </span>
                        </li>
                    @elseif($order->status == 'created')
                        <li class="m-portlet__nav-item">
                            <span class="m-portlet__head-icon btn-lg">
                                <i class="la la-3x la-hourglass-half m-badge--primary"></i>
                            </span>
                        </li>
                    @elseif($order->status == 'payed')
                        <li class="m-portlet__nav-item">
                             <span class="m-portlet__head-icon btn-lg">
                                <i class="la la-3x la-check-circle"></i>
                             </span>
                        </li>
                    @elseif($order->status == 'canceled')
                        <li class="m-portlet__nav-item">
                             <span class="m-portlet__head-icon btn-lg">
                                <i class="la la-3x la-thumbs-down"></i>
                             </span>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
        <div class="m-portlet__body">
            <div class="row">
                <div class="col-lg-8">
                    <h4>
                        <a href="{{route('tours.view', ['tour' => $order->tour->slug])}}"
                           target="_blank"
                        >{{str_limit($order->tour->title, 200)}}</a>
                    </h4>
                    <div class="m--margin-15">
                        <h5>{{trans('checkout.Order price')}}:
                            <strong>{{money_view($order->total)}} {{$order->currency_code}}</strong></h5>
                        <h5>{{trans('checkout.Prepayment')}}:
                            <strong>{{money_view($order->prepay)}} {{$order->currency_code}}
                                + </strong>{{trans('checkout.Transaction fee')}}:
                            <strong>{{money_view($order->prepay * 0.024)}} {{$order->currency_code}}</strong></h5>
                    </div>
                    <div class="m--margin-15">
                        @if($order->status == 'confirmed')
                            <h5>{{trans('cabinet/index.Status')}}: <span
                                        class="m-badge m-badge--primary m-badge--wide m--font-boldest">Подтвержден</span>
                            </h5>
                            {{--<a class="btn m-btn m-btn--icon m-btn--icon-only" {{$order->confirmed && $order->status != 'payed' ?'':'disabled'}}>PAY</a>--}}
                        @elseif($order->status == 'created')
                            <h5>{{trans('cabinet/index.Status')}}: <span class="badge badge-warning">Ожидаем подтверждение</span>
                            </h5>
                        @elseif($order->status == 'payed')
                            <h5>{{trans('cabinet/index.Status')}}: <span class="badge badge-success">Оплачено</span>
                            </h5>
                        @elseif($order->status == 'canceled')
                            <h5>{{trans('cabinet/index.Status')}}: <span class="badge badge-info">{{trans('cabinet/index.Canceled')}}</span></h5>
                        @endif
                    </div>
                </div>
                <div class="col-lg-4">
                    <label>Начало:</label>
                    <h4 class="m--font-brand">{{$order->date_in->format('d')}} {{trans('date.months.'.$order->date_in->format('F'))}} {{$order->date_in->format('Y')}}</h4>
                   </div>
            </div>
        </div>
        <div class="m-portlet__foot">
            <a href="{{route('cabinet:orders.tour_view', $order->id)}}" class="btn btn-primary">Подробно</a>
            @if($order->status == 'confirmed')
                <a class="btn m-btn btn-success"
                   href="{{route('tours.checkout1', $order->id)}}"
                   {{$order->confirmed && $order->status != 'payed' ?'':'disabled'}}
                >Перейти к оплате</a>
            @endif
            @if($order->status == 'payed')
                <a class="btn m-btn btn-success"
                   href="{{route('cabinet:orders.tour_view', $order->id)}}"
                >Оставить отзыв</a>
            @endif
        </div>
    </div>
</div>
