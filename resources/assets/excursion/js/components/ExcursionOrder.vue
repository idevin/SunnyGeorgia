<template>
    <div>
        <div class="p-order-date">
            <div class="p-order__select-date">
                <div class="d-none d-md-block p-order__select-date-title">
                    {{localization['Select a date']}}:
                </div>
                <input type="text"
                       ref="calendarInput"
                       class="p-order__select-date-input d-lg-none"
                       :placeholder="localization['Excursion date']"
                       readonly
                       :value="availability_date ? new Date(availability_date).toLocaleDateString(locale, {
                            year: 'numeric', month: 'long', day: 'numeric'
                        }) : ''"
                       @click="showCalendar = !showCalendar;scrollTo('calendarInput','calendar')"
                >
                <div ref="calendarForm" class="p-order__select-date-form"
                     :class="{'p-order__select-date-form_active': showCalendar}"
                >
                    <excursion-calendar
                            :availability="availability"
                            :form-action="formAction"
                            @selectDay="setDayData($event)"
                            @show-calendar="showCalendar = $event"
                            :localization="localization"
                    >
                    </excursion-calendar>
                </div>
            </div>
            <div class="p-order__select-participates">
                <template  v-if="excursion.type === 'group'">
                    <div class="d-none d-md-block p-order__select-participates-title">{{localization['The number of people in the car']}}:</div>
                    <input ref="participateInput" type="text" class="p-order__select-participates-input d-lg-none"
                           v-model="priceGroupText"
                           :placeholder="localization['The number of people in the car']"
                           @click="showParticipatesForm = !showParticipatesForm;scrollTo('participateInput','part')"
                           readonly
                    >
                </template>
                <template v-else>
                    <div class="d-none d-md-block p-order__select-participates-title">{{localization['Number of participants']}}:</div>
                    <input ref="participateInput" type="text" class="p-order__select-participates-input d-lg-none"
                           v-model="personsTotalText"
                           :placeholder="localization['Number of participants']"
                           @click="showParticipatesForm = !showParticipatesForm;scrollTo('participateInput','part')"
                           readonly
                    >
                </template>
                <div ref="participateForm" class="p-order__select-participates-form"
                     :class="{'p-order__select-participates-form_active': showParticipatesForm}"
                >
                    <template v-if="excursion.type === 'group'">
                        <div class="p-order__select-item-block cursor-pointer"
                             v-for="(price_group, index) in prices.group"
                             @click="selectedPriceGroup = index"
                             :class="{'p-order__select-item-block_active': selectedPriceGroup === index}"
                        >
                            <div class="p-order__select-description">
                                {{localization['from']}} {{price_group.price_from}} {{localization['to']}} {{price_group.price_to}} {{localization['persons']}}:
                            </div>
                            <div class="p-order__select-control">
                                <span class="p-order__select-price">{{price_group.price | moneyFormatterFilter}} {{currencyCode}}</span>
                            </div>
                        </div>
                    </template>
                    <template v-else>
                        <div class="p-order__select-item-block">
                            <div class="p-order__select-description">
                              {{localization['Adults']}} - <span style="font-weight: bold">{{prices.adult.price | moneyFormatterFilter}}</span>&nbsp;{{currencyCode}}
                            </div>
                            <div class="p-order__select-control">
                            <span class="p-order__select-minus"
                                  @click="decrementAdults"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30">
                                 <g>
                                  <line transform="rotate(90 15,15.000000000000002) "
                                        id="svg_2" y2="21" x2="15" y1="9" x1="15"
                                        fill="none"/>
                                 </g>
                                </svg>
                            </span>
                                <span class="p-order__select-count">{{adults}}</span>
                                <span class="p-order__select-plus"
                                      @click="incrementAdults"
                                >
                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30">
                                 <g>
                                  <line id="svg_1" y2="21" x2="15" y1="9" x1="15" fill="none"/>
                                  <line transform="rotate(90 15,15.000000000000002) " id="svg_2" y2="21" x2="15"
                                        y1="9"
                                        x1="15" fill="none"/>
                                 </g>
                                </svg>
                            </span>
                            </div>
                        </div>
                        <template v-if="prices.child && prices.child.price">
                            <div class="p-order__select-item-block">
                                <div class="p-order__select-description">
                                  {{localization['Kids']}} {{localization['to']}} {{prices.child.price_to}} - <span style="font-weight: bold">{{prices.child.price | moneyFormatterFilter}}</span>&nbsp;{{currencyCode}}
                                </div>
                                <div class="p-order__select-control">
                                <span class="p-order__select-minus"
                                      @click="decrementChild"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30">
                                     <g>
                                      <line transform="rotate(90 15,15.000000000000002) "
                                            id="svg_2" y2="21" x2="15" y1="9" x1="15"
                                            fill="none"/>
                                     </g>
                                    </svg>
                                </span>
                                    <span class="p-order__select-count">{{child}}</span>
                                    <span class="p-order__select-plus"
                                          @click="incrementChild"
                                    >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30">
                                     <g>
                                      <line id="svg_1" y2="21" x2="15" y1="9" x1="15" fill="none"/>
                                      <line transform="rotate(90 15,15.000000000000002) " id="svg_2" y2="21" x2="15"
                                            y1="9"
                                            x1="15" fill="none"/>
                                     </g>
                                    </svg>
                                </span>
                                </div>
                            </div>
                        </template>
                        <template v-if="prices.baby && prices.baby.price">
                            <div class="p-order__select-item-block">
                                <div class="p-order__select-description">
                                    {{localization['Kids']}} {{localization['to']}} {{prices.baby.price_to}} - <span style="font-weight: bold">{{prices.baby.price | moneyFormatterFilter}}</span> {{currencyCode}}
                                </div>
                                <div class="p-order__select-control">
                                <span class="p-order__select-minus"
                                      @click="decrementBaby"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30">
                                     <g>
                                      <line transform="rotate(90 15,15.000000000000002) "
                                            id="svg_2" y2="21" x2="15" y1="9" x1="15"
                                            fill="none"/>
                                     </g>
                                    </svg>
                                </span>
                                    <span class="p-order__select-count">{{baby}}</span>
                                    <span class="p-order__select-plus"
                                          @click="incrementBaby"
                                    >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30">
                                     <g>
                                      <line id="svg_1" y2="21" x2="15" y1="9" x1="15" fill="none"/>
                                      <line transform="rotate(90 15,15.000000000000002) " id="svg_2" y2="21" x2="15"
                                            y1="9"
                                            x1="15" fill="none"/>
                                     </g>
                                    </svg>
                                </span>
                                </div>
                            </div>
                        </template>
                    </template>
                    <div class="p-order__departure-time"
                         v-if="availability_times && availability_times.length"
                    >
                        <div class="p-order__departure-time-title">{{localization['Select time']}}:</div>
                        <div class="p-order__departure-time-wrap">
                            <div class="p-order__departure-time-item"
                                 v-for="(time, index) in availability_times"
                                 @click="availability_time = time; availability_time_index = index"
                                 :class="{ 'p-order__departure-time-item_active' : time === availability_time}"
                            >{{time.slice(0, 5)}}</div>
                        </div>
                    </div>
                    <div class="p-order__accept d-lg-none">
                        <div class="p-order_send-query__wrapper"><button @click="showParticipatesForm = false" class="p-order__send-query"><span>Применить</span></button></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="p-order-details">
            <div class="row">
                <div class="col-md-7">
                    <div class="p-order-details__title">
                        {{localization['Order details']}}
                    </div>
                    <p>{{localization['Date']}}:
                        <strong v-if="availability_date">
                            {{new Date(availability_date).toLocaleDateString(locale, {
                                year: 'numeric', month: 'long', day: 'numeric'})}}
                        </strong>
                    </p>
                    <p>{{localization['Time']}}:
                        <strong v-if="availability_time">
                            {{availability_time.slice(0, 5)}}
                        </strong>
                    </p>
                    <template v-if="excursion.type === 'group'">
                        <p>{{localization['Individual excursion']}}:
                            <strong>
                                {{prices.group[selectedPriceGroup].price_from}} - {{prices.group[selectedPriceGroup].price_to}} {{localization['persons']}}
                            </strong>
                        </p>
                    </template>
                    <template v-else>
                        <p>{{localization['Adults']}}:
                            <strong>
                                {{adults}}
                                <span v-if="prices.adult.price">
                                x {{prices.adult.price | moneyFormatterFilter}} {{currencyCode}} =
                                    {{(prices.adult.price * adults) | moneyFormatterFilter}} {{currencyCode}}
                            </span>
                            </strong>
                        </p>
                        <template v-if="prices.child && prices.child.price && child">
                            <p>{{localization['Kids']}} {{localization['to']}} {{prices.child.price_to}}:
                                <strong>
                                    {{child}}
                                    <span v-if="prices.child.price">
                                    x {{prices.child.price | moneyFormatterFilter}} {{currencyCode}} =
                                        {{(prices.child.price * child) | moneyFormatterFilter}} {{currencyCode}}
                                </span>
                                </strong>
                            </p>
                        </template>
                        <template v-if="prices.baby && prices.baby.price && baby">
                            <p>{{localization['Kids']}} {{localization['to']}} {{prices.baby.price_to}}:
                                <strong>
                                    {{baby}}
                                    <span v-if="prices.baby.price">
                                    x {{prices.baby.price | moneyFormatterFilter}} {{currencyCode}} = {{(prices.baby.price * baby) | moneyFormatterFilter}} {{currencyCode}}
                                </span>
                                </strong>
                            </p>
                        </template>
                    </template>
                    <div class="p-order-message">
                        <limited-textarea
                            v-model="notes"
                            class-name="p-order-textarea"
                            :rows="4"
                            :max="800"
                            :placeholder="localization['Ask your question to the tour operator']"
                        ></limited-textarea>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="p-order__right-item">
                        <div class="p-order__right-title">{{localization['Cost']}}:</div>
                        <div class="p-order__right-price">
                            <span class="p-order__right-price_big"
                                  v-if="totalBookingPrice"
                            >
                                {{totalBookingPrice | moneyFormatterFilter}}
                            </span>
                            {{currencyCode}}
                        </div>
                    </div>
                    <div class="p-order__right-item">
                        <div class="p-order__right-title">
                            {{localization['Prepay']}}:
                        </div>
                        <div class="p-order__right-price">
                            <span class="p-order__right-price_big">
                                {{prepay | moneyFormatterFilter}}
                            </span>
                            {{currencyCode}}
                        </div>
                        <div class="p-order__right-subtitle">
                            {{localization['After booking confirm']}}
                        </div>
                    </div>
                    <div class="p-order_send-query__wrapper"
                         v-if="excursionInProcess"
                    >
                        <shared-loader></shared-loader>
                    </div>
                    <div class="p-order_send-query__wrapper"
                         v-else
                    >
                        <button v-if="excursion.availability_future.length"
                                id="excursion-order-button-for-gtm"
                                class="p-order__send-query"
                                @click="onBookingSubmit"
                                :disabled="excursionInProcess || excursionFinished"
                                :class="[excursionFinished ? 'finished' : '']"
                        >
                            <span>{{order_btn_text}}</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import ExcursionCalendar from './ExcursionCalendar'
    import LimitedTextarea from "../../../shared-components/LimitedTextarea";
    import SharedLoader from "../../../shared-components/SharedLoader"
    export default {
        components: {LimitedTextarea, ExcursionCalendar, SharedLoader},
        props: ['formAction', 'excursion', 'availability', 'localization', 'vat', 'prices', 'currencyCode', 'locale'],
        data() {
            return {
                showCalendar: false,
                availability_times: [],
                adults: 1,
                baby: 0,
                child: 0,
                showParticipatesForm: false,
                notes: null,
                availability_date: null,
                availability_time: null,
                availability_time_index: 0,
                selectedPriceGroup: 0,
                group_pid: null,
            }
        },
        computed: {
            personsTotalText () {
                return this.localization['Adults'] + ': ' + this.adults +
                    (this.child ?
                            ', ' + this.localization['Kids'] + ' ' +
                            this.localization['to'] + ' ' +
                            this.prices.child.price_to + ': ' +
                            this.child : ''
                    ) +
                    (this.baby ?
                            ', ' + this.localization['Kids'] + ' ' +
                            this.localization['to'] + ' ' +
                            this.prices.baby.price_to + ': ' +
                            this.baby : ''
                    )
            },
            prepay() {
                let percent = this.vat ? this.excursion.prepay : this.excursion.commission;
                return percent / 100 * this.totalBookingPrice
            },
            excursionFinished() {
                return this.$store.state.excursion.excursionFinished
            },
            excursionInProcess() {
                return this.$store.state.excursion.excursionInProcess
            },
            user() {
                return this.$store.getters.user
            },
            'order_btn_text'() {
                return this.excursionFinished ? this.localization['Request is accepted'] : this.localization['Send request']
            },
            totalBookingPrice(){
                if(this.excursion.type === 'group') {
                    return this.prices.group[this.selectedPriceGroup].price
                } else {
                    return (this.adults * this.prices.adult.price) +
                        (this.child * this.prices.child.price) +
                        (this.baby * this.prices.baby.price)
                }

            },
            priceGroupText() {
                return this.localization['from'] + ' ' +
                    this.prices.group[this.selectedPriceGroup].price_from + ' ' +
                    this.localization['to'] + ' ' +
                    this.prices.group[this.selectedPriceGroup].price_to + ' ' +
                    this.localization['persons']
            },
            availabilityId() {
                return this.availability[this.availability_date][this.availability_time_index].id
            }
        },
        methods: {
            scrollTo(to, kind) {
                let top = window.scrollY + this.$refs[to].getBoundingClientRect().top;
                if(this.showCalendar && kind==='calendar' || this.showParticipatesForm && kind==='part')window.scrollTo(0,top)
            },
            incrementAdults() {
                let result = parseInt(this.adults);
                if (result < 10) {
                    this.adults = result + 1
                }
            },
            decrementAdults() {
                let result = parseInt(this.adults);
                if (result > 1) {
                    this.adults = result - 1
                }
            },
            incrementChild() {
                let result = parseInt(this.child);
                if (result < 5) {
                    this.child = result + 1
                }
            },
            decrementChild() {
                let result = parseInt(this.child);
                if (result > 0) {
                    this.child = result - 1
                }
            },
            incrementBaby() {
                let result = parseInt(this.baby);
                if (result < 5) {
                    this.baby = result + 1
                }
            },
            decrementBaby() {
                let result = parseInt(this.baby);
                if (result > 0) {
                    this.baby = result - 1
                }
            },
            setDayData(data) {
                this.availability_times = data.times;
                this.availability_time = data.times[0];
                this.availability_time_index = 0;
                this.availability_date = data.date
            },
            onBookingSubmit() {
                this.$gtm.trackEvent({
                    event: 'GAEvent',
                    category: 'Booking excursion',
                    action: 'start',
                    label: this.excursion.title,
                });
                let excursionOrder = {
                    excursion_id: this.excursion.id,
                    excursion_availability_id: this.availabilityId,
                    amount_adults: this.adults,
                    amount_child: this.child,
                    amount_baby: this.baby,
                    group_pid: this.excursion.type === 'group' ? this.prices.group[this.selectedPriceGroup].id : null,
                    notes: this.notes,
                    email: this.user ? this.user.email : null,
                    mobile: this.user ? this.user.mobile : null,
                };
                this.$store.commit('setExcursionInProcess', true);
                this.$store.commit('setExcursionOrder', excursionOrder);

                if (!this.user) {
                    this.$store.commit('authModalTab', 'login');
                    this.$gtm.trackEvent({
                        event: 'GAEvent',
                        category: 'Booking excursion',
                        action: 'login_to_book',
                        label: this.excursion.title,
                    });
                } else if (!this.user.mobile_number || !this.user.mobile_confirmed) {
                    this.$store.commit('authModalTab', 'confirm-phone');
                    this.$gtm.trackEvent({
                        event: 'GAEvent',
                        category: 'Booking excursion',
                        action: 'confirm_phone_to_book',
                        label: this.user.email,
                    });
                } else {
                    this.$store.dispatch('sendExcursionOrder').then(() => {
                        this.$store.commit('authModalTab', 'product-accepted');
                        this.$gtm.trackEvent({
                            event: 'GAEvent',
                            category: 'Booking excursion',
                            action: 'finish',
                        });
                    });
                }
            },
        }
    }
</script>
