<template>
    <div class="accommodations-calendar bg-white">
        <div class="text-center bg-gray accommodations-calendar__step">
            <h3 class="h2 text-black mb-0"><span class="">1.</span> {{localization['Select date']}}:</h3>
        </div>
        <div class="accommodations-calendar__wrapper bg-gray">
            <v-calendar
                    is-double-paned
                    :attributes='attributes'
                    @dayclick='dayClicked'
            ></v-calendar>
        </div>
        <div class="text-center bg-gray accommodations-calendar__step">
            <h3 class="h2 text-black mb-0"><span class="">2.</span> {{localization['Select time']}}:</h3>
        </div>
        <div class="bg-gray">
            <ul class="available-times-list">
                <li v-for="item in availability_times" class="available-times-item">
                    <button
                            type="button"
                            class="available-times-button btn"
                            :class="{ 'btn-success' : item.amount != 0, 'btn-warning' : item.time == booking.excursion_availability_time}"
                            :disabled="item.amount == 0"
                            :data-id="item.id"
                            :data-date="item.date"
                            :data-time="item.time"
                            @click="onTimeSelect"
                    >{{item.time | timeFormatter}}
                    </button>
                </li>
            </ul>
        </div>
        <div class="text-center bg-gray accommodations-calendar__step">
            <h3 class="h2 text-black mb-0" v-if="excursion.type == 'group'"><span class="">3.</span> {{localization['Choose how much you will be in the car']}}:</h3>
            <h3 class="h2 text-black mb-0" v-else-if="excursion.type == 'person'"><span class="">3.</span> {{localization['Please indicate the number of adults and children']}}:</h3>
        </div>
        <div class="bg-gray">
            <div class="ml-lg-4 mb-4">
                <!--<div class="row justify-content-center align-items-center">-->
                <div class="row" v-if="excursion.type == 'group'">
                    <div class="col">
                        <div class="quantity-primary row mb-2" v-for="(group,k) in excursion.prices" v-if="k > 2">
                            <div class="col col-md-2 col-lg-2"></div>
                            <div class="quantity-item align-items-center col col-md-8 col-lg-8">
                                <button class="btn btn-outline-primary btn-block"
                                        :class="{ 'btn-warning' : k == booking.group_pid}"
                                        @click="orderGroup(k)">
                                    <h3 class="h2 text-black mb-0 pull-left" style="line-height: 1.7!important;">
                                        <span>{{localization['from']}}</span>&nbsp;
                                        <span>{{group.price_from}}</span>&nbsp;
                                        <span>{{localization['to']}}</span>&nbsp;<span>{{group.price_to}}</span>&nbsp;
                                        <span>{{localization['persons']}}</span>
                                    </h3>
                                    &nbsp;
                                    <div class="price pull-right">
                                        <strong>{{group.price | moneyFormatterFilter}}&nbsp;{{currency_code}}</strong>
                                    </div>

                                </button>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="row" v-else-if="excursion.type == 'person'">
                    <div class="col">
                        <div class="quantity-primary mb-2">
                            <div class="quantity-item flex-column align-items-center price">
                                <strong  v-if="excursion.prices[0].price">{{excursion.prices[0].price | moneyFormatterFilter}}&nbsp;{{currency_code}}</strong>
                                <strong v-else>Бесплатно</strong>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="quantity-primary mb-2">
                            <div class="quantity-item flex-column align-items-center price">
                                <strong v-if="excursion.prices[2].price">{{excursion.prices[2].price | moneyFormatterFilter}}&nbsp;{{currency_code}}</strong>
                                <strong v-else>Бесплатно</strong>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="quantity-primary mb-2">
                            <div class="quantity-item flex-column align-items-center price">
                                <strong v-if="excursion.prices[1].price">{{excursion.prices[1].price | moneyFormatterFilter}}&nbsp;{{currency_code}}</strong>
                                <strong v-else>Бесплатно</strong>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" v-if="excursion.type == 'person' && excursion.prices[0].price">
                    <div class="col">
                        <div class="quantity-primary">
                            <div class="quantity-item flex-column align-items-center">
                                <span class="h4 d-block mb-2 text-black text-transform-none">{{localization['Adults']}}:</span>
                                <div class="quantity ml-0">
                                    <span class="quantity-arrows minus" @click="decrementAdults">-</span>
                                    <input type="number" class="qty" v-model="booking.amount_adults" readonly=""
                                           name="adult">
                                    <span class="quantity-arrows plus" @click="incrementAdults">+</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="quantity-primary">
                            <div class="quantity-item flex-column align-items-center">
                                <span class="h4 d-block mb-2 text-black text-transform-none">{{localization['Kids']}} {{localization['to']}} {{excursion.prices[2].price_to}}:</span>
                                <div class="quantity ml-0">
                                    <span class="quantity-arrows minus" @click="decrementChildren">-</span>
                                    <input type="number" class="qty" v-model="booking.amount_child" readonly=""
                                           name="adult">
                                    <span class="quantity-arrows plus" @click="incrementChildren">+</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="quantity-primary">
                            <div class="quantity-item flex-column align-items-center">
                                <span class="h4 d-block mb-2 text-black text-transform-none">{{localization['Kids']}} {{localization['to']}} {{excursion.prices[1].price_to}}:</span>
                                <div class="quantity ml-0">
                                    <span class="quantity-arrows minus" @click="decrementBaby">-</span>
                                    <input type="number" class="qty" v-model="booking.amount_baby" readonly=""
                                           name="adult">
                                    <span class="quantity-arrows plus" @click="incrementBaby">+</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="bg-white">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <span class="h3 text-black d-block">{{localization['Add message to the order']}}:</span>
                    <limited-textarea v-model="booking.notes"
                                      :max="800"
                                      :placeholder="localization['Ask your question to the tour operator']"
                    ></limited-textarea>
                </div>
                <div class="col-md-6">
                    <button @click="bookingReset" class="pull-right btn" title="Reset form"><i class="fa fa-times"></i>
                    </button>
                    <span class="h3 text-black d-block font-weight-bold">{{localization['Order details']}}:</span>
                    <div class="result-text mb-4" v-if="excursion.type == 'group'">
                        <ul class="list-unstyled">
                            <li>{{localization['Date']}}: <b>{{booking.excursion_availability_date | dateFormatter}}</b>
                            </li>
                            <li>{{localization['Time']}}: <b>{{booking.excursion_availability_time | timeFormatter}}</b>
                            </li>
                            <li>{{localization['Individual tour']}}</li>
                        </ul>
                    </div>
                    <div class="result-text mb-4" v-else-if="excursion.type == 'person'">
                        <ul class="list-unstyled">
                            <li>{{localization['Date']}}: <b>{{booking.excursion_availability_date | dateFormatter}}</b>
                            </li>
                            <li>{{localization['Time']}}: <b>{{booking.excursion_availability_time | timeFormatter}}</b>
                            </li>
                            <li>{{localization['Adults']}}: <b>{{booking.amount_adults}}</b>
                                <span v-if="excursion.prices[0].price">
                                    x {{excursion.prices[0].price | moneyFormatterFilter}}&nbsp;{{currency_code}} = {{(excursion.prices[0].price * booking.amount_adults) | moneyFormatterFilter}}&nbsp;{{currency_code}}
                                </span>
                            </li>
                            <li>{{localization['Kids']}} {{localization['to']}} {{excursion.prices[2].price_to}}: <b>{{booking.amount_child}}</b>
                                <span v-if="excursion.prices[2].price">x {{excursion.prices[2].price | moneyFormatterFilter}}&nbsp;{{currency_code}} = {{(excursion.prices[2].price * booking.amount_child) | moneyFormatterFilter}}&nbsp;{{currency_code}}</span>
                            </li>
                            <li>{{localization['Kids']}} {{localization['to']}} {{excursion.prices[1].price_to}}: <b>{{booking.amount_baby}}</b> <span
                                    v-if="excursion.prices[1].price">x {{excursion.prices[1].price | moneyFormatterFilter}}&nbsp;{{currency_code}} = {{(excursion.prices[1].price * booking.amount_baby) | moneyFormatterFilter}}&nbsp;{{currency_code}}</span>
                            </li>
                        </ul>
                    </div>
                    <div class="d-flex align-items-center mb-2">
                        <span class="h3 text-black d-block font-weight-bold text-transform-none mr-4 mb-0">{{localization['Cost']}}:</span>
                        <div class="price" v-if="!isNaN(totalBookingPrice)">
                            <strong>{{totalBookingPrice | moneyFormatterFilter}}&nbsp{{currency_code}}</strong>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-4">
                        <span class="h3 text-black d-block font-weight-bold text-transform-none mr-4 mb-0">
                            {{localization['Prepay']}}:<br>
                        <small>{{localization['After booking confirm']}}</small></span>
                        <div class="price" v-if="!isNaN(totalBookingPrice)">
                            <strong>{{prepay | moneyFormatterFilter}}&nbsp{{currency_code}}</strong>
                        </div>
                    </div>
                    <button type="button" :class="[excursionFinished ? 'btn-success' : 'btn-primary']"
                            class="btn  btn-block text-black font-weight-bold mb-3"
                            @click="onBookingSubmit"
                            :disabled="!formIsValid || excursionInProcess || excursionFinished">{{order_btn_text}}
                        <i v-if="excursionInProcess" class="fa fa-spinner fa-pulse fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import LimitedTextarea from "../../../shared-components/LimitedTextarea";
    var moment = require('moment');

    export default {
        components: {LimitedTextarea},
        props: ['formAction', 'excursionSrc', 'excursionTimesSrc', 'localization', 'softRegistration'],
        data() {
            return {
                showSoft: true,
                orderSuccess: false,
                composerCurrencies: null,
                selected_availability: {},
                currency_code: '',
                options: [],
                excursion: {
                    paid_options: [],
                    local_price_adult: 0,
                    local_price_excursion: 0,
                    local_price_kid: 0,
                    availability_future: []
                },
                is_ordering: false,
                ordered: false,
                booking: {
                    notes: '',
                    amount_adults: 0,
                    amount_kids: 0,
                    amount_child: 0,
                    amount_baby: 0,
                    group_pid: 0,
                    excursion_availability_id: null,
                    excursion_availability_date: null,
                    excursion_availability_time: null
                },
                selectedDate: null,
                attrs:
                    {
                        available: {
                            key: 'available',
                            highlight: {
                                backgroundColor: '#8cd8b1',
                                backgroundBorder: '#8cd8b1',
                                borderColor: '#8cd8b1',
                                borderRadius: '4px'
                            },
                            contentStyle: {
                                color: '#000'
                            },
                            dates: []
                        },
                        current: {
                            key: 'current',
                            highlight: {
                                backgroundColor: '#ffc411',
                                backgroundBorder: '#ffc411',
                                borderColor: '#ffc411',
                                borderRadius: '4px'
                            },

                            contentStyle: {
                                color: '#000',
                            },
                            dates: new Date()
                        }
                    }
            }
        },
        computed: {
            prepay() {
                return this.excursionSrc.commission / 100 * this.totalBookingPrice
            },
            availability_times() {
                let selectedDate = new Date(this.attrs.current.dates).setHours(0, 0, 0, 0);
                let times = [];
                this.excursion.availability_future.map(function (item) {
                    let iteratedDate = new Date(item.date).setHours(0, 0, 0, 0);
                    if (iteratedDate == selectedDate) {
                        times.push({
                            id: item.id,
                            date: item.date,
                            time: item.time,
                            amount: item.amount,
                        });
                    }
                });
                return times.sort(this.compare);
            },
            user() {
                return this.$store.getters.user
            },
            totalBookingPrice() {
                let total_price = 0;
                if (this.excursion.local_price_excursion === null) {
                    total_price = Math.round(((this.booking.amount_adults * this.excursion.prices[0].price) + (this.booking.amount_child * this.excursion.prices[2].price) + (this.booking.amount_baby * this.excursion.prices[1].price)) * 100) / 100;
                } else {
                    total_price = Math.round(this.excursion.local_price_excursion * 100) / 100;
                }
                for(let index in this.options){
                    total_price += this.options[index].local_price;
                }
                return total_price;
            },
            attributes() {
                return [
                    this.attrs.available,
                    this.attrs.current
                ];
            },
            currentDate() {
                return this.$store.getters.currentDate
            },
            tomorrowDate() {
                return this.$store.getters.tomorrowDate
            },
            formIsValid() {
                if (this.excursion.type == 'person') {
                    return this.booking.excursion_availability_id && (this.booking.amount_adults || this.booking.amount_kids);
                } else {
                    return this.booking.excursion_availability_id && this.booking.group_pid;
                }

            },
            personsIsSelected() {
                if (this.excursion.type == 'person') {
                    return this.booking.amount_adults || this.booking.amount_kids;
                } else {
                    return this.booking.group_pid;
                }
            },
            'order_btn_text'() {
                return this.excursionFinished ? this.localization['Booked'] : this.localization['Send request']
            },
            excursionFinished () {
                return this.$store.state.tour.excursionFinished
            },
            excursionInProcess () {
                return this.$store.state.tour.excursionInProcess
            }
        },
        watch: {
            booking: {
                handler() {
                    localStorage.setItem('excursion_booking_' + this.excursion.id, JSON.stringify(this.booking));
                },
                deep: true,
            },
            'excursion.availability_future'(value) {
                for (let i in value) {
                    if (!this.attrs.available.dates.includes(value[i].date) && value[i].amount > 0) {
                        this.attrs.available.dates.push(value[i].date);
                    }
                }
            },
            softRegistration(value) {
                if (value.email && this.is_ordering) {
                    this.onBookingSubmit();
                } else {
                    this.is_ordering = false;
                }
            },
            'booking.amount_adults' (val) {
                if(val < 1) {
                    this.$set(this.booking, 'amount_child', 0);
                    this.$set(this.booking, 'amount_kids', 0);
                    this.$set(this.booking, 'amount_baby', 0);
                }
            }
        },
        methods: {
            orderGroup(k) {
                this.excursion.local_price_excursion = this.excursion.prices[k].price;
                this.booking.group_pid = k;
            },
            compare(a, b) {
                if (a.time < b.time)
                    return -1;
                if (a.time > b.time)
                    return 1;
                return 0;
            },
            onTimeSelect(event) {
                this.booking.excursion_availability_id = event.target.dataset.id;
                this.booking.excursion_availability_date = event.target.dataset.date;
                this.booking.excursion_availability_time = event.target.dataset.time;
                this.$forceUpdate();
            },
            incrementAdults() {
                let result = parseInt(this.booking.amount_adults);
                if (result < 99999) {
                    result++;
                    this.booking.amount_adults = result
                }
            },
            decrementAdults() {
                let result = parseInt(this.booking.amount_adults);
                if (result > 0) {
                    result--;
                    this.booking.amount_adults = result
                }
            },
            incrementChildren() {
                if(this.booking.amount_adults > 0) {
                    let result = parseInt(this.booking.amount_child);
                    if (result < 99999) {
                        result++;
                        this.booking.amount_kids = result
                        this.booking.amount_child = parseInt(this.booking.amount_child) + 1;
                    }
                } else {
                    this.$toasted.info(this.localization['at least 1 adult'])
                }
            },
            decrementChildren() {
                let result = parseInt(this.booking.amount_child);
                if (result > 0) {
                    result--;
                    this.booking.amount_kids = result
                    this.booking.amount_child = parseInt(this.booking.amount_child) - 1;
                }
            },
            incrementBaby() {
                if(this.booking.amount_adults > 0) {
                    this.booking.amount_baby = parseInt(this.booking.amount_baby) + 1;
                } else {
                    this.$toasted.info(this.localization['at least 1 adult'])
                }
            },
            decrementBaby() {
                let result = parseInt(this.booking.amount_baby);
                if (result > 0) {
                    result--;
                    this.booking.amount_baby = parseInt(this.booking.amount_baby) - 1;
                }
            },
            setCurrentDay(payload) {
                this.attrs.current.dates = payload
            },
            dayClicked(day) {
                let today = new Date().setHours(0, 0, 0, 0);
                if (day.dateTime < today) {
                    this.$toasted.error(this.localization['Only upcoming dates can be selected'])
                } else {
                    this.$store.dispatch('receiveCurrentDate', moment(day.date).format('YYYY-MM-DD'));
                    this.setCurrentDay(this.currentDate);


                    if(this.availability_times.length == 1) {
                        this.booking.excursion_availability_id = this.availability_times[0].id;
                        this.booking.excursion_availability_date = this.availability_times[0].date;
                        this.booking.excursion_availability_time = this.availability_times[0].time;
                        this.$forceUpdate();
                    }

                }
            },
            stopOrdering(){
                this.is_ordering = false;
            },
            startOrdering(){
                this.is_ordering = true;
            },
            onBookingSubmit() {
                this.startOrdering();
                if (!this.formIsValid) {
                    this.$toasted.error(this.localization['No excursion time selected']);

                    return false
                }
                if (!this.personsIsSelected) {
                    this.$toasted.error(this.localization['No number of participants']);
                    return false
                }
                let excursionOrder = {
                    excursion_id: this.excursion.id,
                    excursion_availability_id: this.booking.excursion_availability_id,
                    amount_adults: this.booking.amount_adults,
                    amount_kids: this.booking.amount_kids,
                    amount_child: this.booking.amount_child,
                    amount_baby: this.booking.amount_baby,
                    group_pid: this.booking.group_pid,
                    notes: this.booking.notes,
                    email: this.user ? this.user.email : null,
                    mobile: this.user ? this.user.mobile : null,
                    options: this.options
                };
                this.$store.commit('setExcursionInProcess', true);
                this.$store.commit('setExcursionOrder', excursionOrder);

                if (!this.user) {
                    this.$store.commit('authModalTab', 'registration');
                } else if (! this.user.mobile_number || ! this.user.mobile_confirmed) {
                    this.$store.commit('authModalTab', 'confirm-phone')
                } else {
                    this.$store.dispatch('sendExcursionOrder').then(() => {
                        this.$store.commit('authModalTab', 'product-accepted')
                    });
                }
            },
            bookingReset() {
                this.booking.excursion_availability_date = null;
                this.booking.excursion_availability_time = null;
                this.booking.excursion_availability_id = null;
                this.booking.amount_adults = 0;
                this.booking.amount_kids = 0;
                this.booking.amount_child = 0;
                this.booking.amount_baby = 0;
                this.booking.group_pid = 0;
                this.booking.notes = '';
                this.$store.dispatch('receiveCurrentDate', moment().format('YYYY-MM-DD'));
                this.setCurrentDay(this.currentDate);
                localStorage.removeItem('excursion_booking_' + this.excursion.id);
            }
        },
        filters: {
            dateFormatter: function (value) {
                let day = moment(value);
                if (day.isValid()) {
                    return day.format('DD MMMM YYYY');
                } else {
                    return '';
                }
            },
            timeFormatter: function (value) {
                if (typeof value === 'string' || value instanceof String)
                    return value.slice(0, 5);
                else
                    return '';
                // let day = moment('2018-01-01 ' + value);
                // if (day.isValid()) {
                //     return day.format('HH:mm');
                // } else {
                //     return '';
                // }
            },
        },
        created() {
            this.excursion = this.excursionSrc;
            // this.order_btn_text = this.localization['To order'];
            if (!this.excursion.local_price_excursion && this.excursion.local_price_adult && !this.excursion.local_price_kid) {
                this.excursion.local_price_kid = this.excursion.local_price_adult;
            }
            if (this.excursion.local_price_excursion) {
                this.excursion.local_price_kid = null;
                this.excursion.local_price_adult = null;
                this.excursion.local_price_child = null;
                this.excursion.local_price_baby = null;
                this.excursion.local_price_excursion = null;
            }
            moment.locale(document.documentElement.lang);
            let self = this;
            document.addEventListener("DOMContentLoaded",  () => {
                if (window.Laravel.currency_code)
                    this.currency_code = window.Laravel.currency_code;

                if (localStorage.getItem('excursion_booking_' + self.excursion.id)) {
                    self.booking = JSON.parse(localStorage.getItem('excursion_booking_' + self.excursion.id));
                    self.setCurrentDay(new Date(self.booking.excursion_availability_date));

                    self.booking.amount_child = 0;
                    self.booking.amount_baby = 0;

                    if(self.excursion.type == 'group') {
                        self.excursion.local_price_excursion = self.excursion.prices[self.booking.group_pid].price;
                    }
                } else {
                    let tomorrowInRightFormat = moment().add(1, 'days').format('YYYY-MM-DD');
                    self.setCurrentDay(tomorrowInRightFormat);
                }
            });
        }
    }
</script>

<style lang="scss">

    .quantity-item .btn-outline-primary:hover,
    .quantity-item .btn-outline-primary:focus {
        background-color: transparent;
        box-shadow: 0 0 0 0.2rem rgba(253,233,8,.5);
    }
    .quantity-item .btn-outline-primary.btn-warning,
    .quantity-item .btn-outline-primary.btn-warning:hover,
    .quantity-item .btn-outline-primary.btn-warning:focus {
        background-color: #ffc411 !important;
        box-shadow: 0 0 0 0.2rem rgba(253,233,8,.5);
    }

    .available-times-item {
        padding: 2px;
    }

    .available-times-list {
        display: flex;
        list-style: none;
        justify-content: center;
        margin: 0 auto;
        padding: 0;
        flex-wrap: wrap;
    }

    .accommodations-calendar {
        display: flex;
        flex-flow: column;
        border-top: 2px solid #dbdbdb;
    }

    .accommodations-calendar__wrapper {
        width: auto;
        text-align: center;
        margin: auto;
        background-color: #f6f6f6;
        padding: 20px;
        border: 1px solid #dbdbdb;
        border-radius: 3px;
    }

    .c-header {
        padding: 0px 0px 15px 0px;
    }

    .accommodations-calendar__step {
        margin-top: 15px;
        margin-bottom: 10px;
    }

    .c-pane-container {
        background-color: #f6f6f6 !important;
        border: none !important;
    }

    .calendar-help {
        justify-content: center;
    }

    .c-day-content-wrapper .c-day-content {
        cursor: pointer !important;
        font-size: 15px;
        font-weight: inherit;
        line-height: normal;
        margin: 5px;
    }

    @media (min-width: 543px) {
        // START: убрать стрелочки с календаря
        .c-pane-container {
            position: relative;

            .c-pane {
                position: static;
            }

            .c-pane:first-child {

                .c-arrow-layout:first-child {
                    display: none;
                }

                .c-arrow-layout:last-child {
                    position: absolute;
                    top: 1px;
                    right: 10px;
                }
            }

            .c-pane:last-child {

                .c-arrow-layout:last-child {
                    display: none;
                }

                .c-arrow-layout:first-child {
                    position: absolute;
                    top: 2px;
                    left: 10px;
                }
            }

            .c-header {
                position: static;
            }

            .c-section-wrapper {
                position: static;
            }

            .c-vertical-divider {
                display: none;
            }
        }
        // END: убрать стрелочки с календаря
    }
</style>
