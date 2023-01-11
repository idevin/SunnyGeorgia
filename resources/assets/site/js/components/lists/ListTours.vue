<template>
    <!--V2,3 List Tours-->
    <div class="cards js-scroll-parent">
        <div class="filter_result_details">
            <div class="filter_result_details__item">
                <a href="#" class="btn btn-link text-dark px-0"
                   :class="[order[1] == 'desc' ? 'active' : '']"
                   @click="order = ['updated_at', 'desc']">
                    {{$t('excursions.new')}}
                </a>
                <span class="text-dark" v-if="order[0] == 'updated_at' && order[1] == 'desc'">&#8593;</span>
                <a href="#" class="btn btn-link text-dark ml-3 px-0"
                   :class="[order[1] == 'asc' ? 'active' : '']"
                   @click="order = ['m_price', 'asc']">
                    {{$t('excursions.cheaper')}}
                </a>
                <span class="text-dark" v-if="order[0] == 'm_price' && order[1] == 'asc'">&#8595;</span>
                <a href="#" class="btn btn-link text-dark ml-3 px-0"
                   :class="[order[1] == 'desc' ? 'active' : '']"
                   @click="order = ['m_price', 'desc']">
                    {{$t('excursions.expensively')}}
                </a>
                <span class="text-dark" v-if="order[0] == 'm_price' && order[1] == 'desc'">&#8593;</span>
                <div class="btn-group mx-2" role="group">
                    <a href="#" class="btn btn-light text-dark" v-if="pages.current > 1"
                       @click="pages.current -= 1">
                        <i class="fa fa-arrow-left"></i>
                    </a>
                    <select class="form-control mx-1" v-model="pages.limit">
                        <option value="10">10</option>
                        <option value="20">20</option>
                    </select>
                    <a href="#" class="btn btn-light text-dark" v-if="pages.current < pages.last"
                       @click="pages.current += 1">
                        <i class="fa fa-arrow-right"></i>
                    </a>
                </div>
                <span class="filter_result_details__label">{{$t('tours.Found')}}:</span>
                <span class="filter_result_details__content">{{totalFound}}</span>
            </div>
        </div>
        <div class="cards-item" v-for="(tour, k) in tours">
            <div class="card card-primary flex-md-row">
                <div class="card-img">
                    <a :href="tour.slug | viewUrl(routeView)" target="_blank">
                        <div :class="[rybbon(k).type ? 'ribbon-'+ rybbon(k).type : '']" class="ribbon" v-if="rybbon(k)"
                             v-text="rybbon(k).title"></div>
                        <div class="card-layer">
                            <span class="card-search d-flex align-items-center justify-content-center rounded-circle">
                                <svg class="icon icon--search" width="31px" height="32px">
                                    <use xlink:href="#search"></use>
                                </svg>
                            </span>
                        </div>
                    </a>
                    <img :src="tourImg(k)" :alt="tour.title">
                </div>
                    <div class="card-info">
                        <div class="card-header">
                            <div class="card-header-item">
                                <h3 class="card-title">
                                    <a :href="tour.slug | viewUrl(routeView)" target="_blank">{{tour.title}}</a>
                                </h3>
                                <span class="text-subtitle" v-if="tour.place">
                                    <svg class="icon icon--location-sm" width="22px" height="32px">
                                        <use xlink:href="#location-sm"></use>
                                    </svg>
                                    {{tour.place.name}}
                                </span>
                            </div>
                        </div>
                        <div class="card__bottom-part">
                            <div class="card-body">
                                <div class="card-row">
                                    <strong class="card-time">
                                        <span v-if="tour.days > 0">{{tour.days}} {{$t('tours.Days')}}</span>
                                        <span v-if="tour.nights > 0">{{tour.nights}} {{$t('tours.Nights')}}</span>
                                    </strong>
                                </div>
                                <div class="card-row align-items-sm-end">
                                    <ul class="list-unstyled card-list mr-3">
                                        <li>
                                            <span v-if="tour.flight_included">{{$t('tours.Flight')}}:</span>
                                            <span v-if="tour.flight_included">{{$t('tours.Included_in_price')}}</span>
                                            <span v-if="tour.flight_price && tour.flight_cur">{{$t('tours.Flight')}}:</span>
                                            <span v-if="tour.flight_price && tour.flight_cur">{{tour.flight_price}} {{tour.flight_cur.code}}</span>
                                        </li>
                                        <li>
                                            <span>{{$t('tours.Transfer')}}:</span>
                                            <span v-if="tour.transfer_included">{{$t('tours.Included_in_price')}}</span>
                                            <span v-if="tour.transfer_price && tour.transfer_cur">{{tour.transfer_price}} {{tour.transfer_cur.code}}</span>
                                        </li>
                                        <li v-if="tour.food_option_id">
                                            <span>{{$t('tours.Food')}}:</span>
                                            <span>{{tourFood(k)}}</span>
                                        </li>
                                        <li>
                                            <span>{{$t('tours.Accommodation')}}:</span>
                                            <span>{{tourAccommodation(k)}}</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="card-badges"></div>
                                <div class="price price-sale">
                                    <p style="color: green; font-weight: bold; font-size: 20px"></p>
                                    <span>&nbsp<strong>{{tour.m_price | moneyFormatterFilter}} {{currencyCode.code}}</strong></span>
                                    <em v-if="tour.price_per_person">{{$t('tours.Per_person')}}</em>
                                </div>
                                <div class="card-button">
                                    <a :href="tour.slug | viewUrl(routeView)" class="btn btn-outline-primary" target="_blank">
                                        {{$t('main.Learn_more')}}
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="btn-group my-2 pull-right" role="group" v-if="pages.last > 1">
                <a href="#" class="btn btn-light text-dark" v-if="pages.current > 1" @click="pages.current -= 1">
                    <span aria-hidden="true">&laquo;</span>
                </a>
                <a href="#" class="btn btn-light" v-for="i in pages.last" :class="[pages.current == i ? 'active' : '']" @click="pages.current = i">
                    {{i}}
                </a>
                <a href="#" class="btn btn-light text-dark" v-if="pages.current < pages.last" @click="pages.current += 1">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </div>
            <div class="clearfix"></div>
            <div class="text-center loading-wrap" v-if="loading">
                <shared-loader></shared-loader>
            </div>
        </div>
</template>
<script>
// import { EventBus } from '../../app.js';

export default {
    props: [
        'toursSrc',
        'routeView',
        'routeIndex',
    ],
    data() {
        return {
            totalFound: 0,
            tours: [],
            durations: [],
            options: [],
            show: [],
            getString: "",

            tours_list: "",
            loading: true,

            order: ["updated_at", "desc"],
            pshow: 20,
            pages: {
                current: 1,
                last: 0,
                limit: 20
            }
        }
    },
    watch: {
        "order"() {
            this.getTours();
        },
        "pages.current"() {
            this.getTours();
        },
        "pages.limit"() {
            this.getTours();
        }
    },
    mounted() {
        this.tours = this.toursSrc.data;
        this.pages.last = this.toursSrc.last_page;
        this.totalFound = this.toursSrc.total;
        this.loading = false;

        // EventBus.$on("filterChange", (getString) => {
        //     this.getString = "?" + getString;
        //     this.getTours();
        // });
        // EventBus.$on("durationsChange", (durations) => {
        //     this.durations = durations;
        // });
        // EventBus.$on("optionsChange", (options) => {
        //     this.options = options;
        // });
    },
    computed: {
        currencyCode() {
            return this.$store.getters.currency
        },
        getOrderRequest() {
            return '&order=' + this.order.join('__')
        },
        getPageRequest() {
            return '&page=' + this.pages.current
        },
        getLimitRequest() {
            return '&limit=' + this.pages.limit
        }
    },
    filters: {
        viewUrl(slug, routeView) {
            return routeView.replace(':slug', slug);
        },
    },
    methods: {
        locationHref(getString) {
            let url = location.href.split("?");
            window.history.pushState("", "", url[0] + getString);
        },
        tourImg(k) {
            if (this.tours[k].thumb != undefined) {
                if (this.tours[k].thumb.url != undefined) {
                    return this.tours[k].thumb.url
                }
            }
            if (this.tours[k].images.length > 0) {
                if (this.tours[k].images[0].url != undefined) {
                    return this.tours[k].images[0].url
                }
            }
            return "/static/images/assets/cards/card1.jpg"
        },
        rybbon(k) {
            if (this.tours[k].ribbons.length > 0) {
                return this.tours[k].ribbons[0]
            }
            return false
        },
        tourFood(k) {
            return this.tours[k].foodOption ? this.tours[k].foodOption.name : 'Питание не включено в стоимость'
        },
        tourAccommodation(k) {
            let hotels = [];
            this.tours[k].accommodations.forEach((a) => {
                if (hotels.indexOf(a.hotel) < 0 ) {
                    hotels.push(a.hotel);
                }
            });
            return hotels.join();
        },
        tourMinPrice(k) {
            let minPrice = 0;
            this.tours[k].accommodations.forEach((a) => {
                minPrice = (minPrice > a.price_adult || minPrice == 0) ? a.price_adult : minPrice;
            });

            return minPrice
        },
        opts() {
            let res = true;
            return res;
        },
        getTours() {
            this.loading = true;
            if (typeof this._source != typeof undefined) {
                this._source.cancel('Operation canceled due to new request.')
            }

            this._source = axios.CancelToken.source();

            let paramsStart = this.getString ? this.getString : '?';
            this.locationHref(paramsStart + this.getPageRequest + this.getOrderRequest + this.getLimitRequest);
            axios.get(this.routeIndex + paramsStart + this.getPageRequest + this.getOrderRequest + this.getLimitRequest, {
                cancelToken: this._source.token,
                headers: {
                    'Content-Type': 'application/json'
                },
                data: {} //for axios content-type working properly
            }).then((response) => {
                if (typeof response != typeof undefined) {
                    this.loading = false;
                    this.tours = response.data.tours.data;


                    this.pages.last = response.data.tours.last_page;

                    if (this.pages.current > this.pages.last) {
                        this.pages.current = this.pages.last
                    }

                    this.totalFound = response.data.totalFound;
                }

            }).catch(error => {
                if (axios.isCancel(error)) {
                    console.log('Request canceled', error);
                } else {
                    console.log(error);
                }
            });
        }
    }
}
</script>
<style>
.loading-wrap {
    position: absolute;
    width: 100%;
    height: 100%;
    left: 8px;
    top: 0;
    padding-top: 30%;
    background: rgba(255, 255, 255, 0.8);
}
</style>
