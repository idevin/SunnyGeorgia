<template>
    <div>
        <div class="text-center bg-gray accommodations-calendar__step">
            <h3 class="h2 text-black mb-0"><span class="">2.</span> {{localization['Select the number of participants']}}:</h3>
        </div>
        <div class="row mt-2">
            <div class="col">
                <div class="quantity-primary">
                    <div class="quantity-item flex-column align-items-center">
                        <span class="h4 d-block mb-2 text-black text-transform-none">{{localization['Adults']}}:</span>
                        <div class="quantity ml-0">
                            <span class="quantity-arrows minus" @click="decrementAdults">-</span>
                            <input type="number" class="qty" v-model="booking.adults" readonly=""
                                   name="adults">
                            <span class="quantity-arrows plus" @click="incrementAdults">+</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="quantity-primary">
                    <div class="quantity-item flex-column align-items-center">
                        <span class="h4 d-block mb-2 text-black text-transform-none">{{localization['Kids']}}:</span>
                        <div class="quantity ml-0">
                            <span class="quantity-arrows minus" @click="decrementChildren">-</span>
                            <input type="number" class="qty" v-model="booking.child" readonly=""
                                   name="child">
                            <span class="quantity-arrows plus" @click="incrementChildren">+</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center bg-gray accommodations-calendar__step">
            <h3 class="h2 text-black mb-0"><span class="">3.</span> {{localization['Choose the desired accommodation option']}}:</h3>
        </div>

        <table class="table table-bordered text-center mt-2">
            <thead>
                <tr>
                    <th width="35%">{{localization['Accommodation']}}</th>
                    <th v-for="room in rooms">{{room}},<small>({{allow[room][0].adults}} adults)</small></th>
                    <th>{{localization['Extras. beds']}}</th>
                    <th>{{localization['Kids']}}</th>
                </tr>
            </thead>

            <tr v-for="hotel in hotels">
                <td>{{hotel}}</td>
                <td
                        v-for="room in rooms" class="class-room"
                        :class="classRoom(hotel, room)"
                        @click="selectRoom(hotel, room)"
                >{{roomPriceAdult(hotelRooms(acoms[hotel]), room)}}</td>
                <td>{{acoms[hotel][0].price_additional}}</td>
                <td>{{acoms[hotel][0].price_kid}}</td>
            </tr>
        </table>
        <div class="row mb-3 mb-md-0">
            <div class="col-md-6">
                <accommodations-food-counter
                        :localization="localization"></accommodations-food-counter>
            </div>

            <div class="col-md-6 pl-lg-5">
                <accommodations-transfer-counter
                        :localization="localization"></accommodations-transfer-counter>
            </div>
        </div>
        <hr>
        <div class="row mt-2">
            <div class="col-md-5 mb-4">
                <span class="h3 d-block mb-2 text-black text-transform-none">{{localization['Add message to the order']}}:</span>
                <limited-textarea v-model="booking.notes"
                                  :max="800"
                                  :placeholder="localization['Ask your question to the tour operator']"
                ></limited-textarea>
            </div>
            <div class="col-md-7">
                <div class="mb-4">
                    <span class="h3 text-black d-block font-weight-bold">{{localization['Order details']}}:</span>

                    <div v-if="!loading" class="result-text">
                        <ul class="list-unstyled">
                            <li>{{localization['Date']}}: <strong v-show="currentDate">{{ readableDate }}</strong></li>
                            <li><strong>{{ tourDays }}</strong> {{localization['days and']}} <strong>{{ tourNights }}</strong> {{localization['nights']}}</li>
                            <li>{{localization['Adults']}}: <b>{{ booking.adults }}</b></li>
                            <li v-if="booking.child > 0">{{localization['Kids']}}: <b>{{ booking.child }}</b></li>
                            <li v-if="booking.additional > 0">{{localization['Extras. beds']}}: <b>{{ booking.additional }}</b></li>
                            <li v-if="transferIncluded === true || transferPrice">
                                {{localization['Transfer']}}:
                                <span v-if="transferIncluded === true"><strong>{{localization['enter in cost']}}</strong></span>
                                <span v-if="transferIncluded === false && !transferChecked"><strong>{{localization['not enter']}}</strong></span>
                                <span v-if="transferIncluded === false && transferChecked"><strong>{{localization['Enabled additionally']}}</strong> (+{{ transferPrice }} {{ currency.code }})</span>
                            </li>
                            <li v-if="feedingAvailability && !feedingSelectedType">{{localization['Type of food']}}: <strong>{{localization['undefined']}}</strong></li>
                            <li v-if="feedingAvailability && feedingSelectedType">{{localization['Type of food']}}: <strong>{{ feedingSelectedType }}</strong></li>
                        </ul>
                    </div>
                    <shared-loader v-if="loading"></shared-loader>
                </div>
                <div class="mb-4">
                    <div class="d-flex align-items-center row">
                        <span class="h3 text-black font-weight-bold text-transform-none col">{{localization['Approximate cost']}}:</span>
                        <div class="price col">
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
                    <button type="button" :class="[tourFinished ? 'btn-success' : 'btn-primary']"
                            class="btn  btn-block text-black font-weight-bold mb-3"
                            @click.prevent="onBookingSubmit"
                            :disabled="!formIsValid || tourInProcess || tourFinished">{{order_btn_text}}
                        <i v-if="tourInProcess" class="fa fa-spinner fa-pulse fa-fw"></i>
                    </button>

                    <div v-if="errorFood" class="alert alert-danger" role="alert">
                        {{localization['The desired type of food is not specified']}}
                    </div>
                    <div v-if="errorRooms" class="alert alert-danger" role="alert">
                        {{localization['Select the required number of rooms in a suitable hotel']}}
                    </div>
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
        props: ["tour", 'localization', 'formAction', 'softRegistration'],
        data() {
            return {
                errorFood: false,
                errorRooms: false,
                orderSuccess: false,
                currency_code: '',
                hotels: [],
                rooms: [],
                acoms : {},
                reccom: {
                    room: ""
                },
                booking: {
                    notes: '',
                    adults:0,
                    child: 0,
                    additional:0,
                    hotel: false,
                    room:false,
                    acom: false
                },
                allow: {},
                allowAdults : {}
            }
        },
        watch: {
            'booking.adults'() {
                this.recomRoom();
            },
            'booking.child'() {
                this.recomRoom();
            },
        },
        computed: {
            prepay() {
                return this.tour.commission / 100 * this.totalBookingPrice
            },
            formIsValid() {
                return this.booking.adults > 0 && this.booking.hotel != false && this.booking.room != false && this.allowRoom(this.booking.hotel, this.booking.room) == 2;
            },
            user() {
                return this.$store.getters.user
            },
            loading () {
                return false;
                //return this.$store.getters.loading
            },
            currentDate () {
                return this.$store.getters.currentDate
            },
            tourInfo() {
                return this.$store.getters.tourInfo
            },
            tourId() {
                return this.$store.getters.tourId
            },
            accommodationQuery () {
                return this.$store.getters.accommodationQuery
            },
            foodType () {
                return this.$store.getters.foodType
            },
            foodPrice () {
                return this.$store.getters.foodPrice
            },
            readableDate () {
                return moment(this.currentDate).format('DD.MM.YY')
            },
            currency () {
                return this.$store.getters.currency
            },
            transferPrice () {
                return this.$store.getters.transferPrice
            },
            transferChecked () {
                return this.$store.getters.transferChecked
            },
            transferIncluded () {
                return this.$store.getters.transferIncluded
            },
            feedingSelectedType () {
                return this.$store.getters.feedingSelectedType
            },
            feedingAvailability () {
                return this.$store.getters.feedingAvailability
            },
            feedingSelectedId() {
                return this.$store.getters.feedingSelectedId
            },
            notificationOptions() {
                return this.$store.getters.notificationOptions
            },
            feedingSelectedPrice() {
                return this.$store.getters.feedingSelectedPrice
            },
            tourFlightCost() {
                return this.$store.getters.tourFlightCost
            },
            notes() {
                return this.$store.getters.notes
            },
            tourDays () {
                return this.$store.getters.tourDays
            },
            tourNights () {
                return this.$store.getters.tourNights
            },
            totalPerson() {
                return this.booking.adults + this.booking.child;
            },
            priceChild() {
                if (this.booking.acom.price_kid != null) return this.booking.acom.price_kid;
                if (this.booking.acom.price_additional != null) return this.booking.acom.price_additional;
                return this.booking.acom.price_adult;

            },
            totalBookingPrice() {
                if (this.booking.acom == false || this.booking.adults < 1 || this.booking.acom.price_adult == undefined) return 0;
                return this.booking.adults * this.booking.acom.price_adult + this.booking.child * this.priceChild;
            },
            'order_btn_text'() {
                return this.tourFinished ? this.localization['Booked'] : this.localization['Send request']
            },
            tourFinished () {
                return this.$store.state.tour.tourFinished
            },
            tourInProcess () {
                return this.$store.state.tour.tourInProcess
            }
        },
        methods: {
            room_av(arooms, room) {
                return (arooms[room])?
                    _.groupBy(arooms[room][0].available, function(_av) {
                        return moment(_av.date).format('DD.MM.YY');
                    }) : null;
            },
            orderFoodPrice() {
                if (this.feedingSelectedPrice == 0) {
                    return null
                } else {
                    return this.feedingSelectedPrice
                }
            },
            orderTransferPrice() {
                if (this.transferChecked) {
                    return this.transferPrice
                } else {
                    return null
                }
            },
            onBookingSubmit() {
                let totalFeedPrice = this.orderFoodPrice();
                let totalTransPrice = this.orderTransferPrice();
                let _acom = {};
                this.booking.acom.adults = this.booking.adults;
                this.booking.acom.child = this.booking.child;
                this.booking.acom.additional = this.booking.additional;
                _acom[this.booking.acom.id] = this.booking.acom;

                let tourOrder = {
                    tour_id: this.tourId,
                    date_in: this.currentDate,
                    cost: this.totalBookingPrice,
                    accommodations: _acom,
                    currency_code: this.currency.code,
                    add_transfer: !!this.transferChecked,
                    food: this.feedingSelectedId,
                    food_cost: totalFeedPrice,
                    flight_cost: this.tourInfo.flight_price,
                    transfer_cost: totalTransPrice,
                    notes: this.booking.notes,
                    email: this.user ? this.user.email : null,
                    mobile: this.user ? this.user.mobile : null,
                };
                this.$store.commit('setTourInProcess', true);
                this.$store.commit('setTourOrder', tourOrder);
                if (!this.user) {
                    this.$store.commit('authModalTab', 'registration');
                } else if (! this.user.mobile_number || ! this.user.mobile_confirmed) {
                    this.$store.commit('authModalTab', 'confirm-phone')
                } else {
                    this.$store.dispatch('sendTourOrder').then(() => {
                        this.$store.commit('authModalTab', 'product-accepted')
                    });
                }
            },
            recomRoom() {
                if(this.allowAdults[this.totalPerson] != undefined) {
                    this.reccom.room = this.allowAdults[this.totalPerson][0].room
                } else {
                    if(this.allowAdults[this.totalPerson-1] != undefined) {
                        this.reccom.room = this.allowAdults[this.totalPerson-1][0].room
                    } else {
                        this.reccom.room = "";
                    }
                }

                if (this.booking.adults == 0) {
                    this.reccom.room = "";
                }

                this.booking.hotel = false;
                this.booking.room = false;
                this.booking.acom = false;

            },
            allowRoom(hotel, room) {

                if (this.roomPriceAdult(this.hotelRooms(this.acoms[hotel]), room) == null) return 3;

                if (this.room_av(this.hotelRooms(this.acoms[hotel]), room) == null) return 3;

                if (this.room_av(this.hotelRooms(this.acoms[hotel]), room)[this.readableDate] == undefined) return 3;

                if (this.room_av(this.hotelRooms(this.acoms[hotel]), room)[this.readableDate][0].amount < 1) return 3;

                if (this.room_av(this.hotelRooms(this.acoms[hotel]), room)[this.readableDate][0].amount < this.totalPerson) return 3;

                /*if (this.totalPerson > this.allow[room][0].adults && this.roomPriceBed(this.hotelRooms(this.acoms[hotel]), room) == null) {
                    return 3;
                }

                if (this.totalPerson - 1 > this.allow[room][0].adults && this.roomPriceBed(this.hotelRooms(this.acoms[hotel]), room) != null) {
                    return 3;
                }*/



                if (room == this.reccom.room && this.booking.room == false) {
                    return 1;
                }

                if (hotel == this.booking.hotel && room == this.booking.room) {
                    return 2;
                }

                return 0;
            },
            classRoom(hotel, room) {
                switch(this.allowRoom(hotel, room)) {
                    case 1:
                        return 'bg-success';
                    case 2:
                        return 'bg-warning';
                    case 3:
                        return 'bg-disabled';
                    default:
                        return 'bg-default';
                }
            },
            incrementAdults() {
                this.booking.adults = parseInt(this.booking.adults) < 5 ? parseInt(this.booking.adults) + 1 : parseInt(this.booking.adults);
            },
            decrementAdults() {
                this.booking.adults = parseInt(this.booking.adults) > 0 ? parseInt(this.booking.adults) - 1 : parseInt(this.booking.adults);
            },
            incrementChildren() {
                if(this.booking.adults > 0) {
                    this.booking.child = parseInt(this.booking.child) < 3 ? parseInt(this.booking.child) + 1 : parseInt(this.booking.child);
                } else {
                    this.$toasted.info(this.localization['at least 1 adult'])
                }
            },
            decrementChildren() {
                this.booking.child = parseInt(this.booking.child) > 0 ? parseInt(this.booking.child) - 1 : parseInt(this.booking.child);
            },
            selectRoom(hotel, room) {
                if (this.allowRoom(hotel, room) < 3) {
                    this.booking.hotel = hotel;
                    this.booking.room = room;
                    this.booking.acom = this.bookingAcom(this.hotelRooms(this.acoms[hotel]), room);

                }
            },
            hotelRooms(data) {
                return _.groupBy(data, function(acom) {
                    return acom.room;
                });
            },
            roomAdults(arooms, room) {
                return (arooms[room])? arooms[room][0].adults : null;
            },
            roomPriceAdult(arooms, room) {
                return (arooms[room])? arooms[room][0].price_adult : null;
            },
            roomPriceBed(arooms, room) {
                return (arooms[room])? arooms[room][0].price_additional : null;
            },
            bookingAcom(arooms, room) {
                console.log(arooms[room]);
                return (arooms[room])? arooms[room][0] : false;
            }
        },
        created() {
            this.hotels = Object.keys(_.groupBy(this.tour.accommodations, function(acom) {
                return acom.hotel;
            }));

            this.rooms = Object.keys(_.groupBy(this.tour.accommodations, function(acom) {
                return acom.room;
            }));

            this.allow = _.groupBy(this.tour.accommodations, function(acom) {
                return acom.room;
            });

            this.allowAdults = _.groupBy(this.tour.accommodations, function(acom) {
                return acom.adults;
            });

            this.acoms = _.groupBy(this.tour.accommodations, function(acom) {
                return acom.hotel;
            });
            document.addEventListener("DOMContentLoaded", () => {
                if (window.Laravel.currency_code)
                    this.currency_code = window.Laravel.currency_code;
            })
        }
    }
</script>
<style>
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



    .class-room {
        cursor: pointer;
    }

    .class-room.bg-disabled {
        background: #CCCCCC;
        opacity: 0.2;
        cursor: none;
    }

</style>
