<template>
    <div>
        <div class="col-12">
            <div class="d-flex align-items-center row">
                <span class="h3 text-black font-weight-bold text-transform-none col">{{localization['Approximate cost']}}:</span>
                <div class="price col">
                    <strong>{{totalBookingPrice | moneyFormatter}}&nbsp{{currency_code}}</strong>
                </div>
            </div>
            <div class="d-flex align-items-center mb-4">
                        <span class="h3 text-black d-block font-weight-bold text-transform-none mr-4 mb-0">
                            {{localization['Prepay']}}:<br>
                        <small>{{localization['After booking confirm']}}</small></span>
                <div class="price" v-if="!isNaN(totalBookingPrice)">
                    <strong>{{totalBookingPrice * 0.1 | moneyFormatter}}&nbsp{{currency_code}}</strong>
                </div>
            </div>
        </div>
        <button type="button" v-bind:class="{'btn-primary': !orderSuccess, 'btn-success':orderSuccess }"
                class="btn  btn-block text-black font-weight-bold"
                @click.prevent="onBookingSubmit"
                data-target="#complete" data-toggle="modal" aria-controls="complete"
                :disabled="!formIsValid || orderSuccess || is_ordering">{{order_btn_text}}
            <i v-if="is_ordering || xhrRequest" class="fa fa-spinner fa-pulse fa-fw"></i>
        </button>

        <div v-if="errorFood" class="alert alert-danger" role="alert">
            {{localization['The desired type of food is not specified']}}
        </div>
        <div v-if="errorRooms" class="alert alert-danger" role="alert">
            {{localization['Select the required number of rooms in a suitable hotel']}}
        </div>
    </div>
</template>

<script>
    export default {
        props: ['formAction', 'localization', 'softRegistration'],
        data() {
            return {
                errorFood: false,
                errorRooms: false,
                is_ordering: false,
                orderSuccess: false,
                xhrRequest: false,
                currency_code: '',
                order_btn_text: ''
            }
        },
        computed: {
            formIsValid() {
                return this.$store.getters.totalPersons.adults > 0;
            },
            user() {
                return this.$store.getters.user
            },
            tourInfo() {
                return this.$store.getters.tourInfo
            },
            currentDate() {
                return this.$store.getters.currentDate
            },
            currency() {
                return this.$store.getters.currency
            },
            tourId() {
                return this.$store.getters.tourId
            },
            tourAdults() {
                return this.$store.getters.tourAdults
            },
            tourChildren() {
                return this.$store.getters.tourChildren
            },
            transferChecked() {
                return this.$store.getters.transferChecked
            },
            transferPrice() {
                return this.$store.getters.transferPrice
            },
            totalBookingPrice() {
                return this.$store.getters.tourTotalPrice
            },
            orderedRooms() {
                return this.$store.getters.orderedRooms
            },
            accomm() {
                return this.$store.getters.accomm
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
        },
        watch: {
            // tourAdults(value){
            //     console.log('sdf');
            // },
            softRegistration(value) {
                if (value.email && this.is_ordering) {
                    this.onBookingSubmit();
                } else {
                    this.is_ordering = false;
                }
            }
        },
        filters: {
            moneyFormatter: function (value, code) {
                value = parseFloat(value);
                return value.toFixed(2);
            }
        },
        methods: {
            stopOrdering() {
                this.is_ordering = false;
            },
            startOrdering() {
                this.is_ordering = true;
            },
            isEmpty(obj) {
                for (var key in obj) {
                    return false;
                }
                return true;
            },
            // вычисляемые значения для POST ORDER,
            // основанные на значениях геттеров

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
            // Другое
            onBookingSubmit() {
                this.startOrdering();

                // event.target.disabled = true;

                let totalFeedPrice = this.orderFoodPrice();
                let totalTransPrice = this.orderTransferPrice();
                let isAccommEmpty = false;
                let isAccommHasAdultValue = false;


                // проверяем пустой ли accomm
                // если не пустой, проходимся и чекаем - есть ли значение
                // в поле adults

                if (!this.user && !this.softRegistration.email) {
                    this.$emit('soft-registration-show', true);
                    return false
                } else {

                    this.$toasted.show(this.localization['Order in processing'], this.notificationOptions.default);
                    axios.post(this.formAction, {
                        tour_id: this.tourId,
                        date_in: this.currentDate,
                        cost: this.totalBookingPrice,
                        accommodations: this.accomm,
                        currency_code: this.currency.code,
                        add_transfer: !!this.transferChecked,
                        food: this.feedingSelectedId,
                        food_cost: totalFeedPrice,
                        flight_cost: this.tourInfo.flight_price,
                        transfer_cost: totalTransPrice,
                        notes: this.notes,
                        email: this.softRegistration.email,
                        mobile: this.softRegistration.mobile,
                    })
                        .then((response) => {
                            this.orderSuccess = response.data.success;
                            if (response.data.success) {
                                this.order_btn_text = this.localization['Booked'];
                                $('#tour-order-success-modal').modal('show');
                            } else {
                                //booking fail
                                this.$toasted.error(response.data.msg);
                            }

                        })
                        .catch((error) => {

                            console.log(error);
                            console.log(error.response);
                            console.log(error.response.data);
                            if (error.response.data.message) {
                                this.$toasted.show(error.response.data.message, {
                                    type: 'error'
                                })
                            }
                            if (error.response.data.errors) {
                                for (let i in error.response.data.errors) {
                                    this.$toasted.show(error.response.data.errors[i], {
                                        type: 'error'
                                    })

                                }
                            }
                            this.$toasted.error(error.message)
                        })
                        .finally(() => {
                            this.xhrRequest = this.is_ordering = false;
                        });
                    // this.$toasted.show(this.localization['Indicate the number of adults in one of the accommodations'], this.notificationOptions.default)
                    // event.target.disabled = false

                }

            }
        },
        created() {
            this.order_btn_text = this.localization['Send request'];

            document.addEventListener("DOMContentLoaded", () => {
                if (window.Laravel.currency_code)
                    this.currency_code = window.Laravel.currency_code;


                // if (localStorage.getItem('tour_booking_' + self.excursion.id)) {
                //     self.booking = JSON.parse(localStorage.getItem('excursion_booking_' + self.excursion.id));
                //     self.setCurrentDay(new Date(self.booking.excursion_availability_date));
                // } else {
                //     let tomorrowInRightFormat = moment().add(1, 'days').format('YYYY-MM-DD');
                //     self.setCurrentDay(tomorrowInRightFormat);
                // }

            });
        }
    }
</script>
