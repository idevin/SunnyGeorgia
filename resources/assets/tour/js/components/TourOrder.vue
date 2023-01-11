<template>
    <div>
        <div class="p-order-date">
            <div class="p-order__select-date">
                <div class="d-none d-md-block p-order__select-date-title">
                    {{localization['Select date tour']}}:
                </div>
                <input ref="calendarInput" type="text"
                       class="p-order__select-date-input d-lg-none"
                       placeholder="Дата начала тура"
                       readonly
                       :value="currentDate ? currentDate.toLocaleDateString(locale, {
                            year: 'numeric', month: 'long', day: 'numeric'
                        }) : ''"
                       @click="showCalendar = !showCalendar;scrollTo('calendarInput','calendar')"
                >
                <div ref="calendarForm" class="p-order__select-date-form"
                     :class="{'p-order__select-date-form_active': showCalendar}"
                >
                    <tour-calendar
                            :availability="availability"
                            :form-action="formAction"
                            @accommodations="accommodations = $event"
                            v-model="currentDate"
                            @show-calendar="showCalendar = $event"
                            :localization="localization"
                    >
                    </tour-calendar>
                </div>
            </div>
<!--           START select-participates-->
            <div class="p-order__select-participates">
                <div class="d-none d-md-block p-order__select-participates-title">{{localization['Number of participants']}}:</div>
                <input ref="participateInput" type="text" class="p-order__select-participates-input d-lg-none"
                       :value="personsTotalText"
                       @click="showParticipatesForm = !showParticipatesForm;scrollTo('participateInput','part')"
                       readonly
                >
                <div ref="participateForm" class="p-order__select-participates-form"
                     :class="{'p-order__select-participates-form_active': showParticipatesForm}"
                >
                    <div class="p-order__select-item-block">
                        <div class="p-order__select-description">
                            {{localization['Adults']}}:
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
                    <div class="p-order__select-item-block">
                        <div class="p-order__select-description">
                            {{localization['Kids']}}:
                        </div>
                        <div class="p-order__select-control">
                                <span class="p-order__select-minus"
                                      @click="decrementKids"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30">
                                     <g>
                                      <line transform="rotate(90 15,15.000000000000002) "
                                            id="svg_2" y2="21" x2="15" y1="9" x1="15"
                                            fill="none"/>
                                     </g>
                                    </svg>
                                </span>
                            <span class="p-order__select-count">{{kids}}</span>
                            <span class="p-order__select-plus"
                                  @click="incrementKids"
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
                    <div v-if="kids" class="p-order__child-age">
                        <div class="p-order__child-age-title">{{localization['Kids ages']}}:</div>
                        <div class="p-order__child-age-wrap">
                            <div v-for="(kidAge, index) in kidsAges" :key="index"
                                 class="p-order__select-control"
                            >
                                <span class="p-order__select-minus"
                                      @click="decrementKidAge(index, kidAge)"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30">
                                     <g>
                                      <line transform="rotate(90 15,15.000000000000002) " id="svg_2" y2="21" x2="15"
                                            y1="9" x1="15" fill="none"></line>
                                     </g>
                                    </svg>
                                </span>
                                <span class="p-order__select-count">{{kidAge}}</span>
                                <span class="p-order__select-plus"
                                      @click="incrementKidAge(index, kidAge)"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30">
                                     <g>
                                      <line id="svg_1" y2="21" x2="15" y1="9" x1="15" fill="none"></line>
                                      <line transform="rotate(90 15,15.000000000000002) " id="svg_2" y2="21" x2="15"
                                            y1="9" x1="15" fill="none"></line>
                                     </g>
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="p-order__accept d-lg-none">
                        <div class="p-order_send-query__wrapper"><button @click="showParticipatesForm = false" class="p-order__send-query"><span>Применить</span></button></div>
                    </div>
                </div>
            </div>
<!--           START select-participates-->
        </div>
        <collapse-transition :styles="{animationTimingFunction: 'ease'}">
            <div v-if="bookings && bookings.length" class="p-order-placement">
            <div class="p-order-placement__title">
                Выберите желаемый вариант размещения:
            </div>
            <div class="p-order-placement__items">
                <template v-for="(booking, bookingIndex) in bookings">

                    <collapse-transition>
                        <div class="p-order-placement__item"
                         :class="{'p-order-placement__item_selected': selectedBooking === bookingIndex}"
                         :key="'booking' + bookingIndex"
                         v-show="bookingIndex < bookingsShowLimit || showMoreBookings"
                         @click="selectBooking(bookingIndex)"
                    >
                        <div class="p-order-placement-item__checkbox">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="18px" height="10px">
                                <path fill-rule="evenodd" stroke="rgb(0, 0, 0)" stroke-width="3px" stroke-linecap="butt" stroke-linejoin="miter" fill="none" d="M4.588,5.411 L7.535,8.344 L14.412,1.500 "></path>
                            </svg>
                        </div>
                        <div class="p-order-placement-item__description">
                            <div class="p-order-placement-item__title">
                                {{booking.hotel}}
                            </div>
                            <div class="p-order-placement-item__optimal">
                                {{booking.selectedVariant === 0 && booking.variants[0].approximate ?
                                'Примерное размещение:' : booking.selectedVariant === 0 ?
                                'Оптимальное размещение:' : 'Размещение:'}}
                                {{booking.selectedVariant ? booking.variants[booking.selectedVariant].name : booking.variants[0].name}}

                            </div>
                            <div class="p-order-placement-item__full-description">
                                <div class="p-order-placement-item__more-block">
                                    <collapse-transition>
                                        <div v-if="selectedBooking === bookingIndex">
                                            <div class="p-order-placement-item__optimal-more"
                                            >Больше вариантов по запросу</div>
                                            {{localization['Adults']}}: <strong>{{adults}}</strong><br>

                                            <div v-if="kids">
                                                {{localization['Kids']}}:
                                                <template v-for="(group, key, index) in groupKids">
                                                    <template v-if="index > 0">, </template>
                                                    <strong>{{group}}</strong>({{plural(key, '%d год', '%d года', '%d лет')}})
                                                </template>
                                                <br>
                                            </div>

                                            {{localization['Date']}}: <strong>{{currentDate.toLocaleDateString(locale, {
                                            year: 'numeric', month: 'long', day: 'numeric'
                                            })}}</strong>
                                        </div>
                                    </collapse-transition>
                                    Трансфер:&nbsp; <strong>{{tour.transfer_included ? 'включен в стоимость' : 'не включен в стоимость'}}</strong><br>
                                    Питание:&nbsp; <strong>{{tour.food_option ? tour.food_option.name : 'не включено в стоимость'}}</strong>
                                </div>
                            </div>
                        </div>
                        <div class="p-order-placement-item__price">
                            <div class="p-order__right-item">
                                <div class="p-order__right-title">{{localization['Cost']}}:</div>
                                <div class="p-order__right-price">
                                    <span class="p-order__right-price_big">
                                        {{booking.variants[0].price | moneyFormatterFilter}}
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
                                {{prepay / 100 * booking.variants[0].price | moneyFormatterFilter}}
                                    </span>
                                    {{currencyCode}}
                                </div>
                                <div class="p-order__right-subtitle">
                                    {{localization['After booking confirm']}}
                                </div>
                            </div>
                            <fade-transition>
                                <div class="p-order_send-query__wrapper"
                                    v-if="selectedBooking === bookingIndex"
                                >
                                    <shared-loader v-if="tourInProcess"></shared-loader>
                                    <template v-else>
                                        <button id="tour-order-button-for-gtm"
                                                class="p-order__send-query"
                                                v-if="!tourFinished"
                                                @click="onBookingSubmit(booking)"
                                        >
                                            <span>{{localization['Send request']}}</span>
                                        </button>
                                        <button class="p-order__send-query finished"
                                                v-else
                                        >
                                            <span>{{localization['Request is accepted']}}</span>
                                        </button>
                                    </template>
                                </div>
                            </fade-transition>
                        </div>
                    </div>
                    </collapse-transition>
                </template>
            </div>
            <collapse-transition>
                <div class="p-order-placement__more-items"
                 v-show="bookings.length > bookingsShowLimit"
                 @click="showMoreBookings = !showMoreBookings"
            >
                <span class="p-order-placement__more-items-button">
                    {{showMoreBookings ? 'свернуть' : `Еще размещения (${bookings.length - bookingsShowLimit})`}}
                    <svg xmlns="http://www.w3.org/2000/svg" width="17px" height="11px"
                         :style="{transform: showMoreBookings ? 'rotate(180deg)' : ''}"
                    >
                        <path fill-rule="evenodd" stroke="rgb(10, 10, 10)" stroke-width="2px" stroke-linecap="butt"
                              stroke-linejoin="miter" fill="none" d="M2.361,0.996 L8.000,6.155 L13.639,0.996 "></path>
                    </svg>
                </span>
            </div>
            </collapse-transition>
        </div>
        </collapse-transition>
    </div>
</template>

<script>
    import TourCalendar from './TourCalendar'
    import CollapseTransition from "vue2-transitions/src/Collapse/CollapseTransition";
    import FadeTransition from "vue2-transitions/src/Fade/FadeTransition";
    import ZoomCenterTransition from "vue2-transitions/src/Zoom/ZoomCenterTransition";
    const plural = require('plural-ru');
    export default {
        components: {ZoomCenterTransition, FadeTransition, CollapseTransition, TourCalendar},
        props: ['formAction', 'tour', 'localization', 'availability', 'currencyCode', 'vat', 'locale'],
        data() {
            return {
                showCalendar: false,
                showParticipatesForm: false,
                accommodations: null,
                bookings: null,
                maxPeople: 10,
                adults: 1,
                kids: 0,
                maxKids: 6,
                maxKidAge: 12,
                kidsAges: [],
                selectedBooking: 0,
                currentDate: null,
                showMore: null,
                bookingsShowLimit: 3,
                showMoreBookings: false,
                plural: plural
            }
        },
        watch: {
            accommodations(accommodations) {
                if (accommodations) this.makeBookings()
            },
            adults() {
                this.makeBookings();
            },
            kids() {
                this.makeBookings();
            },
            showParticipatesForm (val) {
                if(val) {
                    this.showCalendar = false
                }
            },
            showCalendar (val) {
                if(val) {
                    this.showParticipatesForm = false
                }
            },
        },
        computed: {
            prepay() {
                return this.vat && this.tour.prepay ? this.tour.prepay : this.tour.commission
            },
            groupKids() {
                return this.kidsAges.reduce((result, item) => {
                    item in result ? result[item]++ : result[item] = 1;
                    return result
                },{});
            },
            user() {
                return this.$store.getters.user
            },
            tourFinished() {
                return this.$store.state.tour.tourFinished
            },
            tourInProcess() {
                return this.$store.state.tour.tourInProcess
            },
            personsTotalText () {
                return 'Взрослых: ' + this.adults + (this.kids ? ', Детей: ' + this.kids : '')
            }
        },
        created(){
            let thisVar = this;

            document.addEventListener('click', function (e) {
                if(!thisVar.checkChildren(thisVar.$refs.participateForm, e.target) && thisVar.$refs.participateForm !== e.target && thisVar.$refs.participateInput !== e.target)thisVar.showParticipatesForm=false;
                if(!thisVar.checkChildren(thisVar.$refs.calendarForm, e.target) && thisVar.$refs.calendarForm !== e.target && thisVar.$refs.calendarInput !== e.target)thisVar.showCalendar=false;
            })
        },
        methods: {
            scrollTo(to, kind) {
                let top = window.scrollY + this.$refs[to].getBoundingClientRect().top
                if(this.showCalendar && kind==='calendar' || this.showParticipatesForm && kind==='part')window.scrollTo(0,top)
            },
            checkChildren(elem, target){
                for(let i=0;i<elem.children.length;i++ ){
                    if(elem.children[i]===target)return true;
                    else {
                        if (this.checkChildren(elem.children[i],target))return true;
                    }
                }
                return false;
            },
            selectBooking(bookingIndex){
                this.selectedBooking = bookingIndex;
                this.showMore = this.showMore === bookingIndex ? null : bookingIndex
            },
            onBookingSubmit(booking){
                this.$gtm.trackEvent({
                    event: 'GAEvent',
                    category: 'Booking tour',
                    action: 'start',
                    label: this.tour.title,
                });
                let tourOrder = {
                    tour_id: this.tour.id,
                    date_in: this.currentDate,
                    hotel: booking.hotel,
                    accommodation_variant: booking.variants[0].name,
                    cost: booking.variants[0].price,
                    adults: this.adults,
                    kids: this.kids,
                    kids_ages: this.kidsAges,
                    email: this.user ? this.user.email : null,
                    mobile: this.user ? this.user.mobile : null,
                };
                this.$store.commit('setTourInProcess', true);
                this.$store.commit('setTourOrder', tourOrder);
                if (!this.user) {
                    this.$store.commit('authModalTab', 'login');
                    this.$gtm.trackEvent({
                        event: 'GAEvent',
                        category: 'Booking tour',
                        action: 'login_to_book',
                        label: this.tour.title,
                    });
                } else if (! this.user.mobile_number || ! this.user.mobile_confirmed) {
                    this.$store.commit('authModalTab', 'confirm-phone');
                    this.$gtm.trackEvent({
                        event: 'GAEvent',
                        category: 'Booking tour',
                        action: 'confirm_phone_to_book',
                        label: this.user.email,
                    });
                } else {
                    this.$store.dispatch('sendTourOrder').then(() => {
                        this.$store.commit('authModalTab', 'product-accepted');
                        this.$gtm.trackEvent({
                            event: 'GAEvent',
                            category: 'Booking tour',
                            action: 'finish',
                        });
                    });
                }
            },
            dayClicked(day) {
                if (day.attributesMap.available) {
                    this.getAccommodations(day.attributesMap.available.customData)
                }
            },
            decrementAdults() {
                if (this.adults > 1) {
                    --this.adults
                }
            },
            incrementAdults() {
                if (this.adults < this.maxPeople) {
                    ++this.adults
                }
            },
            decrementKids() {
                if (this.kids > 0) {
                    --this.kids;
                    this.kidsAges.pop()
                }
            },
            incrementKids() {
                if (this.kids < this.maxKids) {
                    ++this.kids;
                    this.kidsAges.push(1)
                }
            },
            incrementKidAge(index, age) {
                if (age < this.maxKidAge) {
                    this.$set(this.kidsAges, index, ++age)
                }
            },
            decrementKidAge(index, age) {
                if (age > 1) {
                    this.$set(this.kidsAges, index, --age)
                }
            },
            makeBookings(){
                if(this.accommodations){
                    let adults = this.adults, kids = this.kids;
                    let totalPerson = adults + kids;
                    this.bookings =  Object.entries(this.accommodations).map(hotel => {
                        let singl = hotel[1].find(room => room.adults === 1 && room.price_adult);
                        let dbl = hotel[1].find(room => room.adults === 2 && room.price_adult);
                        let tripl = hotel[1].find(room => room.adults === 3 && room.price_adult);
                        let middlePriceRoom = dbl ? dbl : singl ? singl : tripl ? tripl : '';
                        let extraBedPrice = Number(hotel[1][0].price_additional);
                        let kidPrice = Number(hotel[1][0].price_kid);
                        let variants = [];

                        if(!singl) singl = '';
                        if(!dbl) dbl = '';
                        if(!tripl) tripl = '';

                        if(kids && kidPrice) {
                            if(totalPerson === 2) {
                                variants.push({
                                    name: 'взрослый с ребенком в ' + middlePriceRoom.room,
                                    price: middlePriceRoom.price_adult * adults + kids * kidPrice,
                                    approximate: true
                                });
                            }
                            if(totalPerson > 2) {
                                variants.push({
                                    name: this.plural(adults, '%d взрослый', '%d взрослых') + ' с ' +
                                          this.plural(kids, '%d ребенком', '%d детьми') + ' в ' + middlePriceRoom.room,
                                    price: middlePriceRoom.price_adult * adults + kids * kidPrice,
                                    approximate: true
                                });
                            }
                        } else {
                            if(totalPerson === 1) {
                                if (singl.price_adult)
                                    variants.push({
                                        name: '1 x ' + singl.room,
                                        price: +singl.price_adult
                                    });
                                if (dbl.price_adult)
                                    variants.push({
                                        name: '1 x ' + dbl.room,
                                        price: +dbl.price_adult
                                    });
                            }
                            if(totalPerson === 2) {
                                if (dbl.price_adult){
                                    variants.push({
                                        name: '1 x ' + dbl.room,
                                        price: +dbl.price_adult * 2
                                    });
                                }
                                if (singl.price_adult){
                                    variants.push( {
                                        name: '2 x ' + singl.room,
                                        price: 2 * +singl.price_adult
                                    });
                                }
                                if(singl.price_adult && extraBedPrice)  {
                                    variants.push({
                                        name: '1 x ' + singl.room + ' + доп. место',
                                        price: +singl.price_adult + extraBedPrice
                                    })
                                }
                            }
                            if(totalPerson === 3) {
                                if (tripl.price_adult){
                                    variants.push({
                                        name: '1 x ' + tripl.room,
                                        price: +tripl.price_adult * 3
                                    });
                                }
                                if (dbl.price_adult && extraBedPrice) {
                                    variants.push({
                                        name: '1 x ' + dbl.room + ' + доп. место',
                                        price: +dbl.price_adult * 2 + extraBedPrice
                                    });
                                }
                                if (dbl.price_adult && singl.price_adult) {
                                    variants.push( {
                                        name: '1 x ' + dbl.room + ', ' + '1 x ' + singl.room,
                                        price: +dbl.price_adult * 2 + +singl.price_adult
                                    });
                                }
                                if (singl.price_adult) {
                                    variants.push({
                                        name: '3 x ' + singl.room,
                                        price: +singl.price_adult * 3
                                    });
                                }
                            }
                            if(totalPerson === 4) {
                                if (dbl.price_adult)
                                    variants.push({
                                        name: '2 x ' + dbl.room,
                                        price: 2 * +dbl.price_adult * 2
                                    });
                                if (tripl.price_adult && extraBedPrice)
                                    variants.push({
                                        name: '1 x ' + tripl.room + ' + доп. место',
                                        price: +tripl.price_adult * 3 + extraBedPrice
                                    });
                                if (tripl.price_adult && singl.price_adult)
                                    variants.push( {
                                        name: '1 x ' + tripl.room + ', ' + '1 x ' + singl.room,
                                        price: +tripl.price_adult * 3 + +singl.price_adult
                                    });
                                if (singl.price_adult)
                                    variants.push({
                                        name: '4 x ' + singl.room,
                                        price: 4 * +singl.price_adult
                                    });
                                if (singl.price_adult && extraBedPrice)
                                    variants.push({
                                        name: '2 x ' + singl.room + ' + доп. место',
                                        price: 2 * (+singl.price_adult + extraBedPrice)
                                    });
                            }
                            if(totalPerson === 5) {
                                if (tripl.price_adult && dbl.price_adult)
                                    variants.push({
                                        name: '1 x ' + tripl.room + ', ' + '1 x ' + dbl.room,
                                        price: +tripl.price_adult * 3 + +dbl.price_adult * 2
                                    });
                                if (dbl.price_adult && singl.price_adult)
                                    variants.push({
                                        name: '2 x ' + dbl.room + ', ' + '1 x ' + singl.room,
                                        price: +dbl.price_adult * 2 + +singl.price_adult
                                    });
                                if (singl.price_adult)
                                    variants.push( {
                                        name: '5 x ' + singl.room,
                                        price: +singl.price_adult * 5
                                    });
                                if (dbl.price_adult && singl.price_adult && extraBedPrice)
                                    variants.push({
                                        name: '1 x ' + dbl.room + ' + доп. место' + ', ' + '1 x ' + singl.room + ' + доп. место',
                                        price: +dbl.price_adult * 2 + extraBedPrice + +singl.price_adult + extraBedPrice
                                    });
                                if (dbl.price_adult && extraBedPrice)
                                    variants.push({
                                        name: '2 x ' + dbl.room + ' + доп. место',
                                        price: +dbl.price_adult * 2 + extraBedPrice
                                    });
                            }
                            if(totalPerson === 6) {
                                if (tripl.price_adult)
                                    variants.push({
                                        name: '2 x ' + tripl.room,
                                        price: 2 * +tripl.price_adult * 3
                                    });
                                if (dbl.price_adult)
                                    variants.push( {
                                        name: '3 x ' + dbl.room,
                                        price: 3 * +dbl.price_adult * 2
                                    });
                                if (singl.price_adult)
                                    variants.push( {
                                        name: '6 x ' + singl.room,
                                        price: 6 * +singl.price_adult
                                    });
                                if (dbl.price_adult && extraBedPrice)
                                    variants.push({
                                        name: '2 x ' + dbl.room + ' + доп. место',
                                        price: 2 * (+dbl.price_adult * 2 + extraBedPrice)
                                    });
                                if (singl.price_adult && extraBedPrice)
                                    variants.push({
                                        name: '3 x ' + singl.room + ' + доп. место',
                                        price: 3 * (+singl.price_adult + extraBedPrice)
                                    });
                                if (tripl.price_adult && extraBedPrice && singl.price_adult)
                                    variants.push({
                                        name: '1 x ' + tripl.room + ' + доп. место' + ', ' + '1 x ' + singl.room + ' + доп. место',
                                        price: +tripl.price_adult * 3 + extraBedPrice + +singl.price_adult + extraBedPrice
                                    });
                            }
                            if(totalPerson === 7) {
                                if (tripl.price_adult && singl.price_adult) {
                                    variants.push({
                                        name: '2 x ' + tripl.room + ', ' + '1 x ' + singl.room,
                                        price: 2 * +tripl.price_adult * 3 + +singl.price_adult
                                    });
                                }
                                if (dbl.price_adult && singl.price_adult) {
                                    variants.push({
                                        name: '3 x ' + dbl.room + ', ' + '1 x ' + singl.room,
                                        price: 3 * +dbl.price_adult * 2 + +singl.price_adult
                                    });
                                }
                                if (singl.price_adult) {
                                    variants.push({
                                        name: '7 x ' + singl.room,
                                        price: 7 * +singl.price_adult
                                    });
                                }
                                if (dbl.price_adult && extraBedPrice && singl.price_adult) {
                                    variants.push({
                                        name: '2 x ' + dbl.room + ' + доп. место' + ', ' + '1 x ' + singl.room,
                                        price: 2 * (+dbl.price_adult * 2 + extraBedPrice) + +singl.price_adult
                                    });
                                }
                                if (singl.price_adult && extraBedPrice && singl.price_adult) {
                                    variants.push({
                                        name: '3 x ' + singl.room + ' + доп. место' + ', ' + '1 x ' + singl.room,
                                        price: 3 * (+singl.price_adult + extraBedPrice) + +singl.price_adult
                                    });
                                }
                                if (tripl.price_adult && extraBedPrice && dbl.price_adult) {
                                    variants.push({
                                        name: '1 x ' + tripl.room + ' + доп. место' + ', ' + '1 x ' + dbl.room + ' + доп. место',
                                        price: +tripl.price_adult * 3 + extraBedPrice + +dbl.price_adult * 2 + extraBedPrice
                                    });
                                }
                            }
                            if(totalPerson === 8) {
                                if (dbl.price_adult)
                                    variants.push({
                                        name: '4 x ' + dbl.room,
                                        price: 4 * +dbl.price_adult * 2
                                    });
                                if (tripl.price_adult && extraBedPrice)
                                    variants.push({
                                        name: '2 x ' + tripl.room + ' + доп. место',
                                        price: 2 * (+tripl.price_adult * 3 + extraBedPrice)
                                    });
                                if (tripl.price_adult && singl.price_adult)
                                    variants.push( {
                                        name: '2 x ' + tripl.room + ', ' + '1 x ' + singl.room,
                                        price: 2 * (+tripl.price_adult * 3 + +singl.price_adult)
                                    });
                                if (singl.price_adult)
                                    variants.push({
                                        name: '8 x ' + singl.room,
                                        price: 8 * +singl.price_adult
                                    });
                                if (singl.price_adult && extraBedPrice)
                                    variants.push({
                                        name: '4 x ' + singl.room + ' + доп. место',
                                        price: 4 * (+singl.price_adult + extraBedPrice)
                                    });
                                if (dbl.price_adult && extraBedPrice)
                                    variants.push({
                                        name: '2 x ' + dbl.room + ' + доп. место' + ', ' + '1 x ' + dbl.room,
                                        price: 2 * (+dbl.price_adult * 2 + extraBedPrice) + +dbl.price_adult * 2
                                    });
                            }
                            if(totalPerson === 9) {
                                return {hotel: hotel[0], variants: [{name: '', price: 0}]}
                            }
                            if(totalPerson === 10) {
                                return {hotel: hotel[0], variants: [{name: '', price: 0}]}
                            }
                        }

                        variants.length
                            ?
                            variants.sort((a, b) => a.price - b.price)
                            :
                            variants.push({
                                name: this.plural(adults, '%d взрослый', '%d взрослых') + ' в ' + middlePriceRoom.room,
                                price: middlePriceRoom.price_adult * adults,
                                approximate: true
                            });

                        return {hotel: hotel[0], variants, selectedVariant: 0}
                    })
                }
            },
        }
    }
</script>

<style lang="scss">

</style>
