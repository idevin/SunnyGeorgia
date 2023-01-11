<div class="col-lg-6">
    <div class="m-portlet m-portlet--full-height">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
												<span class="m-portlet__head-icon">
													<i class="flaticon-map-location"></i>
												</span>
                    <h3 class="m-portlet__head-text">
                        Бронирования ваших туров
                    </h3>
                </div>
            </div>
        </div>
        <div class="m-portlet__body">

            <div class="tab-content">
                <div class="tab-pane active" id="m_widget5_tab1_content" aria-expanded="true">
                    <!--begin::m-widget5-->
                    <div class="m-widget5">
                        @if($partnerTourBookings && $user->tours()->count() > 0)
                            @foreach($partnerTourBookings as $item)
                                <div class="m-widget5__item">
                                    {{--<div class="m-widget5__pic">--}}
                                    {{--<img class="m-widget7__img"--}}
                                    {{--src="../../assets/app/media/img//products/product6.jpg"--}}
                                    {{--alt="">--}}
                                    {{--</div>--}}
                                    <div class="m-widget5__content">
                                        <h4 class="m-widget5__title">
                                            <a href="{{route('cabinet:partner:tours.booking.view', $item->id)}}">Бронь #{{$item->id}}</a>&nbsp;
                                            <small>от {{$item->created_at}}</small>
                                            @include('layouts.status_layout',['status' => $item->status])
                                                                                        {{--                                                                <a href="{{route('tours.view', ['locale' => $user->locale, 'tour' => $item->tour->slug])}}"--}}
                                            {{--                                                                   target="_blank">#{{$item->tour->id}} {{str_limit($item->tour->title, 200)}}</a>--}}
                                        </h4>
                                        <span class="m-widget5__desc">
                                          <a href="{{route('tours.view', ['tour' => $item->tour->slug])}}"
                                             target="_blank">#{{$item->tour->id}} {{str_limit($item->tour->title, 200)}}</a>
                                        </span>
                                        <div class="m-widget5__info">
																{{--<span class="m-widget5__author">--}}
																	{{--Клиент:--}}
																{{--</span>--}}
                                            {{--<span class="m-widget5__info-label">--}}
																	 {{--#{{$item->customer->id}}--}}
{{--                                                {{$item->customer->first_name}}--}}
{{--                                                {{$item->customer->last_name}}--}}
																{{--</span>--}}
                                            {{--<br>--}}
                                            <span class="m-widget5__author">
																	начало
																</span>
                                            <span class="m-widget5__info-date m--font-info">
																	{{$item->date_in->toDateString()}}
																</span>
                                        </div>
                                    </div>
                                    <div class="m-widget5__stats1">
															<span class="m-widget5__number">
																{{currency($item->prepay, $item->currency_code)}}
															</span>
                                        <br>
                                        <span class="m-widget5__sales">
																предоплата
															</span>
                                    </div>
                                    <div class="m-widget5__stats2">
															<span class="m-widget5__number">
																{{currency($item->total, $item->currency_code)}}
															</span>
                                        <br>
                                        <span class="m-widget5__votes">
																стоимость
															</span>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p>Нету активных бронирований</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-lg-6">
    <div class="m-portlet m-portlet--full-height">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
												<span class="m-portlet__head-icon">
													<i class="flaticon-map-location"></i>
												</span>
                    <h3 class="m-portlet__head-text">
                        Бронирования ваших экскурсий
                    </h3>
                </div>
            </div>
        </div>
        <div class="m-portlet__body">

            <div class="tab-content">
                <div class="tab-pane active" id="m_widget5_tab1_content" aria-expanded="true">
                    <!--begin::m-widget5-->
                    <div class="m-widget5">
                        @if($partnerExcursionBookings && $user->excursions()->count() > 0)
                            @foreach($partnerExcursionBookings as $item)
                                <div class="m-widget5__item">
                                    {{--<div class="m-widget5__pic">--}}
                                    {{--<img class="m-widget7__img"--}}
                                    {{--src="../../assets/app/media/img//products/product6.jpg"--}}
                                    {{--alt="">--}}
                                    {{--</div>--}}
                                    <div class="m-widget5__content">
                                        <h4 class="m-widget5__title">
                                            <a href="{{route('cabinet:partner:excursions.booking.view', $item->id)}}">Бронь #{{$item->id}}</a>&nbsp;
                                            <small>от {{$item->created_at}}</small>

                                            @switch($item->status)
                                                @case('created')
                                                <span class="m-badge m-badge--warning m-badge--wide">{{$item->status}}</span>
                                                @break
                                                @case('confirmed')
                                                <span class="m-badge m-badge--primary  m-badge--wide">{{$item->status}}</span>
                                                @break
                                                @case('canceled')
                                                <span class="m-badge m-badge--default  m-badge--wide">{{$item->status}}</span>
                                                @break
                                                @case('payed')
                                                <span class="m-badge m-badge--success  m-badge--wide">{{$item->status}}</span>
                                                @break
                                                @default
                                                <span class="m-badge m-badge--success  m-badge--wide">{{$item->status}}</span>
                                                @break
                                            @endswitch
                                                {{--                                                                <a href="{{route('tours.view', ['locale' => $user->locale, 'tour' => $item->tour->slug])}}"--}}
                                            {{--                                                                   target="_blank">#{{$item->tour->id}} {{str_limit($item->tour->title, 200)}}</a>--}}
                                        </h4>
                                        <span class="m-widget5__desc">
                                          <a href="{{route('excursions.view', ['excursion' => $item->excursion->slug])}}"
                                             target="_blank">#{{$item->excursion->id}} {{str_limit($item->excursion->title, 200)}}</a>
                                        </span>
                                        <div class="m-widget5__info">
																{{--<span class="m-widget5__author">--}}
																	{{--Клиент:--}}
																{{--</span>--}}
                                            {{--<span class="m-widget5__info-label">--}}
{{--																	 #{{$item->customer->id}}--}}
                                                {{--{{$item->customer->first_name}}--}}
                                                {{--{{$item->customer->last_name}}--}}
																{{--</span>--}}
                                            {{--<br>--}}
                                            <span class="m-widget5__author">
																	начало
																</span>
                                            <span class="m-widget5__info-date m--font-info">
																	{{$item->date_in->toDateString()}}
																</span>
                                        </div>
                                    </div>
                                    <div class="m-widget5__stats1">
															<span class="m-widget5__number">
																{{currency($item->prepay, $item->currency_code)}}
															</span>
                                        <br>
                                        <span class="m-widget5__sales">
																предоплата
															</span>
                                    </div>
                                    <div class="m-widget5__stats2">
															<span class="m-widget5__number">
																{{currency($item->total, $item->currency_code)}}
															</span>
                                        <br>
                                        <span class="m-widget5__votes">
																стоимость
															</span>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p>Нету активных бронирований</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-lg-6">
    <div class="m-portlet m-portlet--head-solid-bg">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
												<span class="m-portlet__head-icon">
													<i class="flaticon-user"></i>
												</span>
                    <h3 class="m-portlet__head-text">
                        Редактировать мою компанию
                    </h3>
                </div>
            </div>
        </div>
        <div class="m-portlet__body">

            <a href="{{route('cabinet:profile.view')}}" class="btn btn-lg btn-primary">Редактировать
                компанию</a>
        </div>
    </div>
</div>