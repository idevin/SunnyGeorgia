@extends('site.layouts.new-app')
@if($tour->{'noindex_' . LaravelLocalization::getCurrentLocale()})
    @section('head_meta')
        <meta name="robots" content="noindex, follow">
    @endsection
@endif
@push('header')
    <title>{{ $tour->getMetaTitle() ?? '' }}</title>
    <meta name="description" content="{{$tour->getMetaDesc() ?? ''}}">
    <meta property="og:title" content="{{$tour->title}}"/>
    <meta property="og:description" content="{{str_limit($tour->intro, 255)}}"/>
    <meta property="og:type" content="website"/>
    <meta property="og:url" content="{{route('tours.view', $tour)}}"/>

    <link rel="stylesheet" href="{{ URL::asset(get_webpack_asset('tour.css')) }}">
    <link rel="preload" as="style" href="{{ URL::asset(get_webpack_asset('tour-vendors.css')) }}">
    @foreach ($cssChunks as $filename)
        <link rel="preload" as="style" href="{{ URL::asset($filename) }}">
    @endforeach
@endpush

@section('content')
    <div class="page-wrapper">
        @if(!$tour->published || !$tour->reviewed)
            <div class="container">
                <div class="row flex-lg-row">
                    <div class="col-lg-9 pr-lg-0 pb-4">
                        @if(!$tour->published)
                            <div class="alert alert-warning" role="alert">
                                {{trans('excursions.Excursion is not published and will not be displayed on the site')}}
                            </div>
                        @endif
                        @if(!$tour->reviewed)
                            <div class="alert alert-warning" role="alert">
                                {{trans('excursions.Excursion is not  verified by the administration and will not be displayed on the site')}}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @else
            @if(Request::input('preview') ==='true')
                <div class="container">
                    <div class="row flex-lg-row">
                        <div class="col-lg-9 pr-lg-0 pb-4">
                            <div class="alert alert-success" role="alert">
                                {{trans('tours.Tour is displayed on the site')}}
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endif
        @if($tour->deleted_at)
            <div class="container">
                <div class="row flex-lg-row">
                    <div class="col-lg-9 pr-lg-0 pb-4">
                        <div class="alert alert-danger" role="alert">
                            {{trans('main.Deleted and not more available for booking')}}
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <main class="page-main">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        {{ Breadcrumbs::view('breadcrumbs::json-ld', Request::route()->name) }}
                        {{ Breadcrumbs::render(Request::route()->name) }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3 order-2 order-lg-1">
                        <side-bar inline-template>
                            @include('site.tours.aside', $asideData)
                        </side-bar>
                    </div>

                    <div class="col-lg-9 order-1 order-lg-2">
                        <div class="p-content">
                            <div class="p-top">
                                <div class="p-top__name">
                                    <h1 class="p-top__title">
                                        {{$tour->title}}
                                    </h1>
                                    <div class="p-top__details">
                                        <div class="p-top__city">
                                            <svg style="vertical-align: -1px;"
                                                 xmlns="http://www.w3.org/2000/svg"
                                                 xmlns:xlink="http://www.w3.org/1999/xlink"
                                                 width="9px" height="13px"
                                            >
                                                <image x="0px" y="0px" width="9px" height="13px"
                                                       xlink:href="data:img/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAANCAMAAABM3rQ0AAAABGdBTUEAALGPC/xhBQAAACBjSFJNAAB6JgAAgIQAAPoAAACA6AAAdTAAAOpgAAA6mAAAF3CculE8AAAApVBMVEX///8mLTcnLTgmLTcnLTgmLTgmLTcnLTgmLTcmLTcnLTgmLTcmLTcnLTgmLTgnLTgmLTcmLTgnLjgmLTcnLTgmLTcnLTgnLTgnLTgmLTcnLTgnLTgnLTgnLTgnLTgmLTcmLTcnLTgmLTcmLTcnLTgmLTgmLTcnLTgmLTcmLTgmLTcmLTcnLTgnLTgmLTcnLTgmLTcmLTcmLTcnLTgnLjgmLTj///9E2XsuAAAAMnRSTlMAGqb1/sxHF+L+V5nJKxeH6wrs/R/ASeeLX979PYrJh+QD+3ec6wwa9Gx40gQG1Do3jPZ1TZUAAAABYktHRACIBR1IAAAAB3RJTUUH4wQSCzU1q0MTLAAAAG9JREFUCNcli1kSglAQA4OoqIgbi4IL7oAKaOZx/6sxYD5SXekKYA3s4WgMwJmQlOkMcM3cWyyb1RobP1ATMgK3CthJjGTfb3LAkSfPSXm+ILjqleam4k6R5vFUynIhi+6Gl+H701NZ+TX++f66bgF51ApVD/qjtAAAAABJRU5ErkJggg=="/>
                                            </svg>
                                            {{trans('tours.From')}} {{$tour->place->name}}
                                        </div>
                                        <div class="p-top__reviews">
                                            <div class="p-top__rating">
                                                @php
                                                    $rating = $avgRating
                                                @endphp
                                                @foreach(range(1,5) as $i)
                                                    <div class="p-top__rating-item">
                                                        @if($rating >0)
                                                            @if($rating >0.5)
                                                                {{--целая--}}
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                     xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                     width="15.5px" height="14.5px">
                                                                    <path fill-rule="evenodd" stroke="rgb(255, 196, 17)"
                                                                          stroke-width="1px" stroke-linecap="butt"
                                                                          stroke-linejoin="miter"
                                                                          fill="rgb(255, 196, 17)"
                                                                          d="M7.251,0.683 L9.487,4.323 L13.639,5.324 L10.868,8.575 L11.199,12.834 L7.251,11.204 L3.303,12.834 L3.633,8.575 L0.863,5.324 L5.015,4.323 L7.251,0.683 Z"/>
                                                                </svg>
                                                            @else
                                                                {{--половина--}}
                                                                <svg
                                                                        xmlns="http://www.w3.org/2000/svg"
                                                                        xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                        width="15.5px" height="14.5px">
                                                                    <path fill-rule="evenodd" stroke="rgb(255, 196, 17)"
                                                                          stroke-width="1px" stroke-linecap="butt"
                                                                          stroke-linejoin="miter" fill="none"
                                                                          d="M10.868,8.575 L11.199,12.834 L7.251,11.204 L3.303,12.834 L3.633,8.575 L0.863,5.324 L5.015,4.323 L7.251,0.683 L9.487,4.323 L13.639,5.324 L10.868,8.575 Z"/>
                                                                    <path fill-rule="evenodd" fill="rgb(255, 196, 17)"
                                                                          d="M3.303,12.834 L3.633,8.575 L0.863,5.324 L5.015,4.323 L7.251,0.683 L7.251,11.204 L3.303,12.834 Z"/>
                                                                </svg>
                                                            @endif
                                                        @else
                                                            {{--пустая--}}
                                                            <svg
                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                    width="15.5px" height="14.5px">
                                                                <path fill-rule="evenodd" stroke="rgb(255, 196, 17)"
                                                                      stroke-width="1px" stroke-linecap="butt"
                                                                      stroke-linejoin="miter" fill="none"
                                                                      d="M7.251,0.683 L9.487,4.323 L13.639,5.324 L10.868,8.575 L11.199,12.834 L7.251,11.204 L3.303,12.834 L3.633,8.575 L0.863,5.324 L5.015,4.323 L7.251,0.683 Z"/>
                                                            </svg>
                                                        @endif
                                                    </div>
                                                    @php
                                                        $rating--
                                                    @endphp
                                                @endforeach
                                                <div class="p-top__rating-number">&nbsp;{{$avgRating}}</div>
                                                <div class="p-top__review-count">{{trans('reviews.Reviews')}}
                                                    : {{$reviews->count()}}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-top__cost">
                                    <div class="p-top__price">
                                        {{trans('tours.from')}}
                                        <span class="p-top__price_big">
                                        {{money_view($tour->minPrice)}}
                                    </span>
                                        {{currency()->getUserCurrency()}}
                                        @if($tour->price_per_person)
                                            <em>{{trans('tours.Per person')}}</em>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @if(count($slider))
                                <div class="p-gallery">
                                    @if($tour->ribbon)
                                        <div class="p-sale-block-wrap">
                                            <div class="p-sale-block">{{$tour->ribbon->title}}</div>
                                        </div>
                                    @endif
                                    <product-gallery inline-template
                                                     :slider="{{json_encode($slider)}}"
                                                     :thumbs="{{json_encode($thumbs)}}"
                                    >
                                        <div class="gallery-swiper" ref="gallery">
                                            <slider animation="fade" v-model="currentImage"
                                                    :indicators="false"
                                                    :interval="5000"
                                                    :autoplay="false"
                                                    height="auto"
                                                    @next="scrollImages('next')"
                                                    @previous="scrollImages('prev')"
                                            >
                                                @foreach($slider as $slide)
                                                    <slider-item>
                                                        <picture class="gallery-swiper__picture fadeInLeft">
                                                            <source type="image/webp"
                                                                    srcset="
                                                        @foreach($slide['webp'] as $key => $image)
                                                                    @if (! $loop->first)
                                                                      ,
@endif
                                                                    {{$image}} {{$key}}
                                                                    @endforeach
                                                                      "
                                                                    sizes="
                                                                (min-width: 1200px) 825px,
                                                                (max-width: 1200px) and (min-width: 992px) 690px,
                                                                (max-width: 992px) and (min-width: 768px) 690px,
                                                                (max-width: 768px) and (min-width: 576px) 510px,
                                                                345px
                                                                "
                                                            >
                                                            <source type="image/jpeg" srcset="
                                                        @foreach($slide['jpeg'] as $key => $image)
                                                                @if (! $loop->first)
                                                                  ,
@endif
                                                                {{$image}} {{$key}}
                                                                @endforeach
                                                                  "
                                                                    sizes="
                                                    (min-width: 1200px) 825px,
                                                    (max-width: 1200px) and (min-width: 992px) 690px,
                                                    (max-width: 992px) and (min-width: 768px) 690px,
                                                    (max-width: 768px) and (min-width: 576px) 510px,
                                                    345px
                                                "
                                                            >
                                                            <img class="gallery-swiper__img"
                                                                 src="{{$slide['origin']}}"
                                                                 alt="{{$tour->title}}"
                                                                 @click="showLightbox('{{$slide['origin']}}')"
                                                                 @if(! $loop->first)
                                                                     style="display: none;"
                                                                    @endif
                                                            >
                                                        </picture>
                                                    </slider-item>
                                                @endforeach
                                            </slider>
                                            <div class="gallery-thumbs_wrapper">
                                                <div class="gallery-thumbs"
                                                     :style="{transform: `translateX(${galleryTopPosition / 4}px)`}"
                                                >
                                                    <div class="gallery-thumbs_picture-wrapper"
                                                         :style="{width: galleryWidth / 4 + 'px', height: galleryWidth / 8 + 'px'}"
                                                         v-for="(image, index) in thumbsData"
                                                         :key="index + 'thumb'"
                                                    >
                                                        <picture class="gallery-thumbs-swiper__picture">
                                                            <source type="image/webp"
                                                                    :data-srcset="image.webp"
                                                            >
                                                            <source type="image/jpeg"
                                                                    :data-srcset="image.jpeg"
                                                            >
                                                            <img class="gallery-thumbs-swiper__img lazyload"
                                                                 src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                                                                 :data-src="image.origin"
                                                                 :alt="`slide ${index+1} thumb`"
                                                                 @click="setVisibleImage(index)"
                                                            >
                                                        </picture>
                                                    </div>
                                                </div>
                                            </div>
                                            <lightbox id="mylightbox"
                                                      ref="lightbox"
                                                      :images="lightboxImages"
                                                      :timeoutDuration="5000"
                                            ></lightbox>
                                        </div>
                                    </product-gallery>
                                </div>
                            @endif
                            <div class="p-description">
                                <div class="p-short-description">
                                    <div class="p-short-description__header">
                                        <h2 class="p-short-description__title">
                                            {{trans('tours.Short description')}}
                                        </h2>
                                        <shared-social-sharing
                                                v-if="domLoaded"
                                                url="{{Request::url()}}"
                                                title="{{$tour->title}}"
                                                description="{{$tour->title}}"
                                                quote="{{$tour->intro}}"
                                        ></shared-social-sharing>
                                    </div>
                                    @if($tour->intro)
                                        <div class="p-short-description__text">
                                            {!! strip_tags($tour->intro) !!}
                                        </div>
                                    @endif

                                    <price-include-exclude inline-template>
                                        <div>
                                            <div class="p-short-description__options-mobile d-md-none">
                                                <div class="p-short-description__include-mobile" @click="activeTab=0"
                                                     :class="{'p-short-description__mobile_active-tab':activeTab==0}">{{trans('tours.Included in price')}}
                                                    :
                                                </div>
                                                <div class="p-short-description__exclude-mobile" @click="activeTab=1"
                                                     :class="{'p-short-description__mobile_active-tab':activeTab==1}">{{trans('excursions.price not include')}}
                                                    :
                                                </div>
                                            </div>
                                            <div class="p-short-description__options">
                                                <div class="p-short-description__include"
                                                     :class="{'p-short-description__mobile_active-content':activeTab==0}">
                                                    <h3 class="p-short-description__include-title d-md-block d-none">
                                                        {{trans('tours.Included in price')}}:
                                                    </h3>
                                                    <ul class="p-description__list">
                                                        @if($tour->transfer_included)
                                                            <li>
                                                                <span>{{trans('tours.Transfer')}} {{trans('tours.Included in price')}}</span>
                                                            </li>
                                                        @endif
                                                        @foreach($tour->priceOptions as $option)
                                                            @if ($option->included)
                                                                <li>
                                                                    <span>{{$option->name}}</span>
                                                                </li>
                                                            @endif
                                                        @endforeach
                                                    </ul>
                                                </div>
                                                <div class="p-short-description__exclude"
                                                     :class="{'p-short-description__mobile_active-content':activeTab==1}">
                                                    <div class="p-short-description__exclude-title d-md-block d-none">
                                                        {{trans('excursions.price not include')}}:
                                                    </div>
                                                    <ul class="p-description__list">
                                                        @if(! $tour->transfer_included)
                                                            <li>
                                                                <span>{{trans('tours.Transfer')}}:&nbsp;</span>
                                                                <span>
                                                              {{money_view(currency($tour->transfer_price, 'USD', currency()->getUserCurrency(), false))}}
                                                            </span>
                                                                <span>{{currency()->getUserCurrency()}}</span>
                                                            </li>
                                                        @endif
                                                        @foreach($tour->priceOptions as $option)
                                                            @if (!$option->included)
                                                                <li>
                                                                    <span>{{$option->name}}</span>
                                                                </li>
                                                            @endif
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </price-include-exclude>
                                </div>
                                @if(count($tour->types))
                                    <div class="p-description__kind">
                                        <h3>{{trans('tours.Type of tour')}}:&nbsp;</h3>
                                        @foreach($tour->types as $option)
                                            @if (!$loop->first)
                                                •
                                            @endif
                                            {{$option->name}}
                                        @endforeach
                                    </div>
                                @endif
                                @if($tour->description)
                                    <tour-description inline-template days="{{$tour->parts->count()}}">
                                        <div class="p-full-description">
                                            <div class="p-full-description__day-selector">
                                                <slide-x-left-transition group>
                                                    @foreach($tour->parts as $day)
                                                        <div class="p-full-description__day-item"
                                                             @click="activeTab = {{$loop->index + 1}}"
                                                             :class="{'p-full-description__day-item_active': activeTab === {{$loop->index + 1}}}"
                                                             key="{{$day->id}}"
                                                        >
                                                            {{$day->name}}
                                                        </div>
                                                    @endforeach
                                                </slide-x-left-transition>
                                            </div>
                                            <div class="p-full-description__day-item-wrap" id="dayItemWrap">
                                                @foreach($tour->parts as $day)
                                                    <div
                                                            class="p-full-description__day-transition-wrap{{$loop->first ? '-first' : ''}}"
                                                            v-show="activeTab === {{$loop->index + 1}}"
                                                            key="day{{$day->id}}"
                                                    >
                                                        <h2 class="p-full-description__day-title"
                                                            :class="{'p-full-description__day-title_active': activeTab === {{$loop->index + 1}}}"
                                                        >
                                                            {{$day->title}}
                                                        </h2>
                                                        <div class="p-full-description__day-text"
                                                             :class="{'p-full-description__day-text_active': activeTab === {{$loop->index + 1}}}"
                                                        >
                                                            {!! $day->description !!}
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="p-full-description__day-selector text-center">
                                                <div class="p-full-description__day-item-prev"
                                                     @click="prev"
                                                     :class="{'p-full-description__day-item_disabled': activeTab <= 1}"
                                                >
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                         xmlns:xlink="http://www.w3.org/1999/xlink"
                                                         width="10px" height="17px">
                                                        <path fill-rule="evenodd" stroke="rgb(10, 10, 10)"
                                                              stroke-width="2px"
                                                              stroke-linecap="butt" stroke-linejoin="miter"
                                                              opacity="0.302" fill="none"
                                                              d="M7.549,15.000 L1.000,8.000 L7.549,1.000 "/>
                                                    </svg>
                                                </div>
                                                <div class="p-full-description__day-item-next"
                                                     @click="next"
                                                     :class="{'p-full-description__day-item_disabled': activeTab >= days}"
                                                >
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                         xmlns:xlink="http://www.w3.org/1999/xlink"
                                                         width="10px" height="21px">
                                                        <path fill-rule="evenodd" stroke="rgb(10, 10, 10)"
                                                              stroke-width="2px"
                                                              stroke-linecap="butt" stroke-linejoin="miter"
                                                              opacity="0.302" fill="none"
                                                              d="M1.451,17.000 L8.000,10.000 L1.451,3.000 "/>
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                    </tour-description>
                                @endif
                                <div class="p-add-description">
                                    <div class="p-add-description__header">
                                        <h3 class="p-add-description__title">
                                            {{trans('excursions.Details')}}
                                        </h3>
                                        <div class="p-description__expand"
                                             data-collapse="p-add-description__text"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                 xmlns:xlink="http://www.w3.org/1999/xlink"
                                                 width="34px" height="17px">
                                                <path fill-rule="evenodd" stroke="rgb(10, 10, 10)" stroke-width="2px"
                                                      stroke-linecap="butt" stroke-linejoin="miter" opacity="0.302"
                                                      fill="none"
                                                      d="M29.731,15.009 L16.500,3.629 L3.269,15.009 "/>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="p-add-description__text collapsed">
                                        <ul class="p-description__list">
                                            @if($tour->days)
                                                <li>
                                                    <span>{{trans('tours.Duration')}}: </span>
                                                    <span>
                                            @if($tour->days)
                                                            {{$tour->days}} {{trans_choice('tours.Days_plural', $tour->days)}}
                                                        @endif
                                                        @if($tour->nights)
                                                            / {{$tour->nights}} {{trans_choice('tours.Nights_plural', $tour->nights)}}
                                                        @endif
                                          </span>
                                                </li>
                                            @endif
                                            <li>
                                                <span>{{trans('tours.Food')}}: </span>
                                                @if($tour->food_option_id)
                                                    <span>{{$tour->foodOption->name}}</span>
                                                @else
                                                    <span>{{trans('tours.not included in price')}}</span>
                                                @endif
                                            </li>
                                            <li>
                                                <span>{{trans('tours.Transfer')}}: </span>
                                                @if($tour->transfer_included)
                                                    <span>{{trans('tours.Included in price')}}</span>
                                                @else
                                                    <span>
                                            {{money_view(currency($tour->transfer_price, 'USD', currency()->getUserCurrency(), false))}}
                                          </span>
                                                    <span>{{currency()->getUserCurrency()}}</span>
                                                @endif
                                            </li>
                                            @if($tour->free_cancel_before)
                                                <li>
                                                    <span>{{trans('tours.Free cancel before')}}: </span>
                                                    <span>
                                              {{$tour->free_cancel_before}}
                                                        {{trans_choice('tours.Days_plural', $tour->free_cancel_before)}}
                                            </span>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            @if(!$tour->deleted_at)
                                <div class="p-description">
                                    <div class="p-short-description">
                                        <h2>
                                            {{trans('orders.Select date tour')}}
                                        </h2>
                                    </div>
                                    <tour-order
                                            v-if="orderVisible"
                                            ref="orderComponent"
                                            :tour="{{$tour}}"
                                            :availability="{{$availability}}"
                                            :localization="{{json_encode(trans('tour-order'))}}"
                                            form-action="{{route('api.accommodations')}}"
                                            currency-code="{{currency()->getUserCurrency()}}"
                                            vat="{{$vat}}"
                                    ></tour-order>
                                </div>


                            @endif
                            <div class="p-prepayment"
                                 v-observe-visibility="{
                                 callback: visibilityChanged,
                                 once: true,
                             }"
                            >
                                <div class="p-prepayment__header">
                                    <h3 class="p-prepayment__title">
                                        {{trans('tours.Prepay and cancellation policy')}}
                                    </h3>

                                </div>
                                <div class="p-prepayment__text">
                                    <p>{{trans('tours.The prepayment is :percent% of the cost of the service.',
                                            ['percent' => $tour->partner->vat ? $tour->prepay : $tour->commission])}}
                                    </p>
                                    <p>{{trans('tours.Free cancellation is possible for :days',
                                            ['days' => $tour->free_cancel_before])}}
                                    </p>
                                </div>
                            </div>
                        </div>
                        @include('site.includes.reviews')
                    </div>
                </div>
            </div>
        </main>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript" src="{{ URL::asset(get_webpack_asset('tour-vendors.js')) }}" defer></script>
    <script type="text/javascript" src="{{ URL::asset(get_webpack_asset('tour.js')) }}" defer></script>
    <script async>
        document.addEventListener('DOMContentLoaded', () => {
            let collapseButtons = document.getElementsByClassName('p-description__expand');
            [...collapseButtons].forEach(el => {
                let target = document.getElementsByClassName(el.dataset.collapse)[0];
                el.addEventListener('click', () => {
                    target.classList.toggle('collapsed');
                    el.classList.toggle('collapsed-rotate');
                }, false);
            });
        });
    </script>
@endpush


