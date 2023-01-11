@extends('site.layouts.new-app')
@if($excursion->{'noindex_' . LaravelLocalization::getCurrentLocale()})
    @section('head_meta')
        <meta name="robots" content="noindex, follow">
    @endsection
@endif
@push('header')
    <title>{{ $excursion->title ?? '' }}</title>
    <meta property="og:title" content="{{$excursion->title}}"/>
    <meta property="og:description" content="{{str_limit($excursion->intro, 255)}}"/>
    <meta property="og:type" content="website"/>
    <meta property="og:url" content="{{route('excursions.view', $excursion)}}"/>
    @if(isset($slider[0]))
        <meta property="og:image" content="{{$slider[0]['origin']}}"/>
    @endif


    <link rel="prefetch" href="{{ URL::asset(get_webpack_asset('excursion-vendors.css')) }}" as="style">
    @foreach ($cssChunks as $filename)
        <link rel="prefetch" href="{{ URL::asset($filename) }}" as="style">
    @endforeach
    <link rel="stylesheet" href="{{ URL::asset(get_webpack_asset('excursion-vendors.css')) }}">
    <link rel="stylesheet" href="{{ URL::asset(get_webpack_asset('excursion.css')) }}">
@endpush

@section('content')
    <div class="page-wrapper">
        @if(!$excursion->published || !$excursion->reviewed)
            <div class="container">
                <div class="row flex-lg-row">
                    <div class="col-lg-9 pr-lg-0 pb-4">
                        @if(!$excursion->published)
                            <div class="alert alert-warning" role="alert">
                                {{trans('excursions.Excursion is not published and will not be displayed on the site')}}
                            </div>
                        @endif
                        @if(!$excursion->reviewed)
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
        @if($excursion->deleted_at)
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

        <main class="page-main container">
            <div class="row">
                <div class="col-12">
                    {{ Breadcrumbs::view('breadcrumbs::json-ld', Request::route()->name) }}
                    {{ Breadcrumbs::render(Request::route()->name) }}
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 order-2 order-lg-1">
                    <side-bar inline-template>
                        @include('site.excursions.aside', $asideData)
                    </side-bar>
                </div>
                <div class="col-lg-9 order-1 order-lg-2">
                    <div class="p-content">
                        <div class="p-top">
                            <div class="p-top__name">
                                <h1 class="p-top__title">
                                    {{$excursion->title}}
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
                                        {{trans('excursions.From')}} {{$excursion->place->name}}
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
                                                                      stroke-linejoin="miter" fill="rgb(255, 196, 17)"
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
                                                    $rating --
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
                                    {{trans('excursions.from')}}
                                    <span class="p-top__price_big">
                                     {{money_view($minPrice)}}
                                </span>
                                    {{$currency}}
                                </div>
                                @if($excursion->type == 'person')
                                    <div class="p-top__adult">{{trans('excursions.Adult')}}</div>
                                @else
                                    <div class="p-top__adult">{{trans('excursions.Per excursion')}}</div>
                                @endif
                            </div>
                        </div>
                        @if(count($slider))
                            <div class="p-gallery">
                                @if($excursion->ribbon)
                                    <div class="p-sale-block-wrap">
                                        <div class="p-sale-block">{{$excursion->ribbon->title}}</div>
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
                                                        <source type="image/jpeg"
                                                                srcset="
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
                                                             alt="{{$slide['alt']}}"
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
                                                    <picture class="gallery-thumbs-swiper__picture"

                                                    >
                                                        <source type="image/webp"
                                                                :data-srcset="image.webp"
                                                        >
                                                        <source type="image/jpeg"
                                                                :data-srcset="image.jpeg"
                                                        >
                                                        <img class="gallery-thumbs-swiper__img lazyload"
                                                             src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                                                             :data-src="image.origin"
                                                             :alt="image.alt"
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
                                        {{trans('excursions.Short description')}}
                                    </h2>
                                    <shared-social-sharing
                                            v-if="domLoaded"
                                            url="{{Request::url()}}"
                                            title="{{$excursion->title}}"
                                            description="{{$excursion->title}}"
                                            quote="{{$excursion->intro}}"
                                    ></shared-social-sharing>
                                </div>
                                @if($excursion->intro)
                                    <div class="p-short-description__text">
                                        {!! strip_tags($excursion->intro) !!}
                                    </div>
                                @endif
                                <price-include-exclude inline-template>
                                    <div>
                                        <div class="p-short-description__options-mobile d-md-none">
                                            <div class="p-short-description__include-mobile" @click="activeTab=0"
                                                 :class="{'p-short-description__mobile_active-tab':activeTab==0}">{{trans('excursions.price include')}}
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
                                                    {{trans('excursions.price include')}}:
                                                </h3>
                                                <ul class="p-description__list">
                                                    @if($excursion->flight_included)
                                                        <li>
                                                            <span>{{trans('excursions.Flight')}}:</span>
                                                            <span>{{trans('excursions.Included in the price')}}</span>
                                                        </li>
                                                    @endif
                                                    @if($excursion->transfer_included)
                                                        <li>
                                                            <span>{{trans('excursions.Transfer')}}:</span>
                                                            <span>{{trans('excursions.Included in the price')}}</span>
                                                        </li>
                                                    @endif
                                                    @foreach($excursion->options as $option)
                                                        @if ($option->options_group_id == 26 && !$option->pivot->value)
                                                            <li>
                                                                <span>{{$option->title}}</span>
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
                                                    @if($excursion->flight_price && $excursion->flightCur)
                                                        <li>
                                                            <span>{{trans('excursions.Flight')}}:</span>
                                                            <span>{{$excursion->flight_price}} {{$excursion->flightCur->code}}</span>
                                                        </li>
                                                    @endif
                                                    @if($excursion->transfer_price && $excursion->transferCur)
                                                        <li>
                                                            <span>{{trans('excursions.Transfer')}}:</span>
                                                            <span>{{$excursion->transfer_price}} {{$excursion->transferCur->code}}</span>
                                                        </li>
                                                    @endif
                                                    @foreach($excursion->options as $option)
                                                        @if ($option->options_group_id == 26 && $option->pivot->value )
                                                            <li>
                                                                <span>{{$option->title}}</span>
                                                            </li>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </price-include-exclude>
                            </div>
                            <div class="p-description__kind">
                                <h3>{{trans('excursions.Type of excursion')}}:</h3>
                                @foreach($excursion->types as $option)
                                    @if (!$loop->first)
                                        •
                                    @endif
                                    {{$option->name}}
                                @endforeach
                            </div>
                            @if($excursion->description)
                                <div class="p-full-description">
                                    <div class="p-full-description__header">
                                        <h2 class="p-full-description__title">
                                            {{trans('main.Description')}}
                                        </h2>
                                        <div class="p-description__expand"
                                             :class="{'collapsed-rotate': showFullDescription}"
                                             @click="showFullDescription = !showFullDescription"
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
                                    <div class="p-full-description__text"
                                         :class="{show: showFullDescription}"
                                    >
                                        {!! $excursion->description !!}
                                    </div>
                                </div>
                            @endif
                            <div class="p-add-description"
                                 v-observe-visibility="{
                                 callback: visibilityChanged,
                                 once: true,
                             }"
                            >
                                <div class="p-add-description__header">
                                    <h3 class="p-add-description__title">
                                        {{trans('excursions.Details')}}
                                    </h3>
                                    <div class="p-description__expand"
                                         :class="{'collapsed-rotate': showDescription}"
                                         @click="showDescription = !showDescription"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                             xmlns:xlink="http://www.w3.org/1999/xlink"
                                             width="34px" height="17px"
                                        >
                                            <path fill-rule="evenodd" stroke="rgb(10, 10, 10)" stroke-width="2px"
                                                  stroke-linecap="butt" stroke-linejoin="miter" opacity="0.302"
                                                  fill="none"
                                                  d="M29.731,15.009 L16.500,3.629 L3.269,15.009 "/>
                                        </svg>
                                    </div>
                                </div>
                                <div class="p-add-description__text"
                                     :class="{'show': showDescription}"
                                >
                                    <ul class="p-description__list">
                                        @if($excursion->start_place)
                                            <li>
                                                <span>{{trans('excursions.Location of the excursion start')}}: </span>
                                                <span>{{$excursion->start_place}}</span>
                                            </li>
                                        @endif

                                        @if($excursion->min_people)
                                            <li>
                                                <span>{{trans('excursions.Number of participants')}}: </span>
                                                <span>{{trans('excursions.min')}} {{$excursion->min_people}}
                                                    @if($excursion->max_people)
                                                        / {{trans('excursions.max')}} {{$excursion->max_people}}
                                                    @endif
                                            </span>
                                            </li>
                                        @endif

                                        @if($excursion->duration > 0)
                                            <li>
                                                <span>{{trans('excursions.Duration')}}</span>
                                                @php
                                                    $days = intval($excursion->duration / 24);
                                                    $hours = $days ? $excursion->duration % 24 : $excursion->duration;
                                                @endphp
                                                <span>
                                                    @if($days)
                                                        {{trans('excursions.days')}}: {{$days}}
                                                    @endif
                                                    @if($hours)
                                                        {{trans('excursions.hours')}}: {{$hours}}
                                                    @endif
                                                 </span>
                                            </li>
                                        @endif
                                        @if($excursion->route_length)
                                            <li>
                                                <span>{{trans('excursions.Length of the route')}}: </span>
                                                <span>{{$excursion->route_length}}</span>
                                            </li>
                                        @endif
                                        @if($excursion->free_cancel_before)
                                            <li>
                                                <span>{{trans('cabinet/excursions.Free cancel before')}}: </span>
                                                <span>{{$excursion->free_cancel_before}} {{trans('cabinet/excursions.Hours')}}</span>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>

                            @if(!$excursion->deleted_at)
                                <div class="p-add-description">
                                    <div class="p-add-description__header">

                                        <h3 class="p-add-description__title">
                                            {{trans('excursion-order.Select date excursion')}}
                                        </h3>
                                    </div>
                                    <excursion-order
                                            v-if="orderVisible"
                                            ref="orderComponent"
                                            form-action="{{route('excursions.request')}}"
                                            :excursion="{{$excursion}}"
                                            :prices="{{$prices}}"
                                            currency-code="{{currency()->getUserCurrency()}}"
                                            locale="{{app()->getLocale()}}"
                                            :availability="{{json_encode($availabilities)}}"
                                            :localization="{{json_encode(trans('excursion-order'))}}"
                                            vat="{{$vat}}"
                                    ></excursion-order>
                                </div>
                            @endif
                        </div>
                        <div class="p-prepayment">
                            <div class="p-prepayment__header">
                                <h3 class="p-prepayment__title">
                                    {{trans('excursions.Prepay and cancellation policy')}}
                                </h3>
                                <div class="p-description__expand"
                                     :class="{'collapsed-rotate': showPrepayment}"
                                     @click="showPrepayment = !showPrepayment"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         xmlns:xlink="http://www.w3.org/1999/xlink"
                                         width="34px" height="17px"
                                    >
                                        <path fill-rule="evenodd" stroke="rgb(10, 10, 10)" stroke-width="2px"
                                              stroke-linecap="butt" stroke-linejoin="miter" opacity="0.302"
                                              fill="none"
                                              d="M29.731,15.009 L16.500,3.629 L3.269,15.009 "/>
                                    </svg>
                                </div>
                            </div>
                            <div class="p-prepayment__text"
                                 :class="{show: showPrepayment}"
                            >
                                <p>{{trans('excursions.The prepayment is :percent% of the cost of the service.',
                                        ['percent' => $excursion->partner->vat ? $excursion->prepay : $excursion->commission])}}
                                </p>
                                <p>{{trans('excursions.Free cancellation is possible for :hours',
                                        ['hours' => $excursion->free_cancel_before])}}
                                </p>
                            </div>
                        </div>
                    </div>
                    @include('site.includes.reviews')
                </div>
            </div>
        </main>
    </div>
@endsection


@push('scripts')
    <script type="text/javascript" src="{{ URL::asset(get_webpack_asset('excursion-vendors.js')) }}" defer></script>
    <script type="text/javascript" src="{{ URL::asset(get_webpack_asset('excursion.js')) }}" defer></script>
@endpush
