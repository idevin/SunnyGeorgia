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
        <div class="cards-item" v-for="excursion in excursions">
            <div class="card card-primary flex-md-row">
                <div class="card-img">
                    <a :href="excursion.slug | viewUrl(routeView)" target="_blank">
                        <div v-if="rybbon(excursion)" :class="[rybbon(excursion).type ? 'ribbon-'+ rybbon(excursion).type : '']" class="ribbon" v-text="rybbon(excursion).title"></div>
                        <div class="card-layer">
                            <span class="card-search d-flex align-items-center justify-content-center rounded-circle">
                                <svg class="icon icon--search" width="31px" height="32px">
                                    <use xlink:href="#search"></use>
                                </svg>
                            </span>
                        </div>
                    </a>
                    <img :src="img(excursion)" :alt="excursion.title">
                </div>
                    <div class="card-info">
                        <div class="card-header">
                            <div class="card-header-item">
                                <h3 class="card-title">
                                <a :href="excursion.slug | viewUrl(routeView)" target="_blank">{{excursion.title}}</a>
                            </h3>
                                <span class="text-subtitle" v-if="excursion.place">
                                <svg class="icon icon--location-sm" width="22px" height="32px">
                                    <use xlink:href="#location-sm"></use>
                                </svg>
                                {{excursion.place.name}}
                            </span>
                            </div>
                        </div>
                        <div class="card__bottom-part">
                            <div class="card-body">
                                <div class="card-row align-items-sm-end">
                                    <ul class="list-unstyled card-list">
                                        <li v-if="excursion.start_place">
                                            <span>{{$t('excursions.Location_of_the_excursion_start')}}:</span>
                                            <span>{{excursion.start_place}}</span>
                                        </li>
                                        <li v-if="excursion.min_people">
                                            <span>{{$t('excursions.Number_of_participants')}}:</span>
                                            <span>Мин: {{excursion.min_people}} <template v-if="excursion.max_people"> / макс {{excursion.max_people}}</template>
                                    </span>
                                        </li>
                                        <li v-if="excursion.duration > 0">
                                            <span>{{$t('excursions.Duration')}}:</span>
                                            <span>
                                        {{excursion.duration | durationDays($t('excursions.days'))}}
                                        {{excursion.duration | durationHours($t('excursions.hours'))}}
                                    </span>
                                        </li>
                                        <li v-if="excursion.route_length">
                                            <span>{{$t('excursions.Length_of_the_route')}}:</span>
                                            <span>{{excursion.route_length}}</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="price price-sale">
                                    <p style="color: green; font-weight: bold; font-size: 20px"></p>
                                    <template v-if="excursion.type == 'group'">
                                        <span><strong>{{excursion.m_price | moneyFormatterFilter}} {{currencyCode.code}}</strong></span>
                                    </template>
                                    <template v-else-if="excursion.type == 'person'">
                                        <span><strong>{{excursion.m_price | moneyFormatterFilter}} {{currencyCode.code}}</strong></span>
                                        <em>{{$t('tours.Per_person')}}</em>
                                    </template>
                                </div>
                                <div class="card-button">
                                    <a :href="excursion.slug | viewUrl(routeView)" class="btn btn-outline-primary" target="_blank">
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
        'productsSrc',
        'routeView',
        'routeIndex',
    ],
    data() {
        return {
            totalFound: 0,
            excursions: [],
            excursions_list: "",
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
            this.getExcursions();
        },
        "pages.current"() {
            this.getExcursions();
        },
        "pages.limit"() {
            this.getExcursions();
        }
    },
    mounted() {
        this.excursions = this.productsSrc.data;
        this.pages.last = this.productsSrc.last_page;
        this.totalFound = this.productsSrc.total;
        this.loading = false;
        // EventBus.$on("filterExcursionsChange", (getString) => {
        //     this.getString = "?" + getString;
        //     this.getExcursions();
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
        durationDays(duration, msg) {
            let dur = parseInt(duration / 24);
            return dur > 0 ? dur + ' ' + msg : '';
        },
        durationHours(duration, msg) {
            let dur = parseInt(duration % 24);
            return dur > 0 ? dur + ' ' + msg : '';
        },
    },
    methods: {
        locationHref(getString) {
            let url = location.href.split("?");
            window.history.pushState("", "", url[0] + getString);
        },
        rybbon(item) {
            if (typeof item.ribbons != "undefined" && item.ribbons != null && item.ribbons.length != null && item.ribbons.length > 0) {
                return item.ribbons[0]
            }
            return false
        },
        img(item) {
            if (item.thumb != undefined) {
                if (item.thumb.url != undefined) {
                    return item.thumb.url
                }
            }
            if (item.new_thumb) {
                return item.new_thumb
            }
            return "/static/images/assets/cards/card1.jpg"
        },
        getExcursions() {
          debugger
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

                    /*  V1 List Excursions  */

                    this.excursions_list = response.data;
                    this.loading = false;

                    /*  V3 List Excursions  */
                    this.excursions = response.data.excursions.data;
                    this.pages.last = response.data.excursions.last_page;

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
