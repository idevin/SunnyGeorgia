<template>
    <div class="excursion-booking-confirm">
        <div v-if="loading" class="m-content">
            <div class="m-portlet m-portlet--mobile">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title" style="width:100%">
                            <h3 class="m-portlet__head-text align-center" style="width:100%">
                                <shared-loader></shared-loader>
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="!loading" class="m-content">
            <div class="m-portlet m-portlet--mobile">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                                Excursion booking id: {{ booking.id }}
                                <small> {{ booking.created_at }}</small>
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <form @submit.prevent="onFormSubmit">

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Customer</label>
                            <div class="col-sm-8 position-relative " v-if="booking.customer">
                                <p>{{booking.customer.first_name}} {{booking.customer.last_name}}</p>
                                <div v-if="booking.customer.email">
                                    email: {{booking.customer.email}} <i
                                        class="fa fa-check-circle-o"
                                        :class="{ 'm--font-success': booking.customer.email_verified }"
                                ></i>
                                </div>
                                <div v-if="booking.customer.mobile_number">
                                    mobile: {{booking.customer.mobile_number}} <i
                                        class="fa fa-check-circle-o"
                                        :class="{ 'm--font-success': booking.customer.mobile_confirmed }"
                                ></i>
                                </div>
                            </div>
                            <div class="col-sm-8" v-else>
                                <div class="alert m-alert m-alert--default" role="alert">
                                    Hidden until paid
                                </div>
                            </div>

                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2">Excursion</label>
                            <div class="col-sm-10">
                                <p>id: {{ excursion.id }} <strong>{{ excursion.title }}</strong>
                                    <a :href="excursionLink"><i class="fa fa-eye"></i></a>
                                </p>
                                <p>{{ excursion.place.name }}</p>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Дата</label>
                            <div class="col-sm-6 col-md-4">
                                <p>{{booking.date_in | readableDate}}</p>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Время</label>
                            <div class="col-sm-6 col-md-4">
                                <p>{{booking.time_in.slice(0,5)}}</p>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Бронирование</label>
                            <div class="col-sm-8 position-relative" v-if="booking.group_pid">
                                <div class="alert m-alert m-alert--default" role="alert">
                                    Группа: от
                                    {{excursion.prices.find(item => item.id === booking.group_pid).price_from}}
                                    до
                                    {{excursion.prices.find(item => item.id === booking.group_pid).price_to}}
                                </div>
                            </div>
                            <div class="col-sm-8 position-relative" v-else-if="!booking.group_pid">
                                <div class="alert m-alert m-alert--default" role="alert">
                                    Взрослые: {{booking.qty_adults}}
                                    Дети: {{booking.qty_kids}}
                                </div>
                                <div class="alert m-alert m-alert--default" role="alert">
                                    Дети до {{excursion.prices[1].price_to}}: {{booking.qty_baby}}
                                </div>
                                <div class="alert m-alert m-alert--default" role="alert">
                                    Дети до {{excursion.prices[2].price_to}}: {{booking.qty_child}}
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Сообщение от клиента</label>
                            <div class="col-sm-8 position-relative">
                                <div class="alert m-alert m-alert--default" role="alert">
                                    {{booking.customer_notes}}
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Цена
                                <br>
                                <span v-if="priceChanged" style="color:red">изменилась</span>
                            </label>
                            <div class="col-sm-6 col-md-4 position-relative ">
                                <div class="input-group">
                                    <input type="number" step="0.01" class="form-control m-input"
                                           v-model="booking.total" aria-describedby="basic-addon2">
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="basic-addon1">{{ booking.currency_code }}</span>
                                    </div>
                                </div>

                                <div class="alert m-alert m-alert--default" role="alert">
                                    При изменении размеры цены мы укажем в письме для клиента о таком
                                    изменении
                                </div>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Предоплата {{initial_prepay_percent|
                                moneyFilter}}&nbsp%</label>
                            <div class="col-sm-6 col-md-4 position-relative ">
                                <div>{{booking.prepay | moneyFilter}} {{ booking.currency_code }}</div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2">Доплата на месте</label>
                            <div class="col-sm-10">
                                <div>{{ surcharge }} {{ booking.currency_code }}</div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Статус бронирования</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="status" v-model="booking.status">
                                    <option disabled value="">выберите статус</option>
                                    <option value="created" disabled>{{localization['Created']}}</option>
                                    <option value="confirmed">{{localization['Confirmed']}}</option>
                                    <option value="payed" disabled>{{localization['Payed']}}</option>
                                    <option value="canceled">{{localization['Canceled']}}</option>
                                </select>
                                <div class="alert m-alert m-alert--default" role="alert">
                                    При смене статуса на "Подтверждено" мы автоматически отправим клиенту ссылку на
                                    оплату.
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Сообщение клиенту</label>
                            <div class="col-sm-8 position-relative">
                                <textarea
                                        cols="30"
                                        rows="5"
                                        class="form-control"
                                        placeholder="Напишите сообщение клиенту"
                                        v-model="booking.partner_notes"
                                ></textarea>
                                <div class="alert m-alert m-alert--default" role="alert">
                                    Сообщение будет добавлено к письму для клиента при смене статуса бронирования
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <button
                                    class="btn btn-primary"
                                    :class="{ 'm-loader' : queryLoading, 'm-loader--light' : queryLoading, 'm-loader--right' : queryLoading }"
                                    :disabled="queryLoading"
                                    @click.prevent="onFormSubmit"
                            >Сохранить изменения
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import moment from 'moment'

    export default {
        props: [
            'formRole',
            'formAction',
            'excursionLink',
            'partnerLink',
            'localization',
            'userLink',
            'initialBooking',
            'excursion'
        ],
        data() {
            return {

                // Пока идет сохранение
                queryLoading: false,
                // Пока идет подтверждение
                queryConfirmedLoading: false,
                // v-models for input fields

                initial_total: 0,
                initial_prepay_percent: 0,
                booking: this.initialBooking
                // place: {},
                // customer: {},
                // user_partner: {},
                // partner: {},
            }
        },
        computed: {
            loading() {
                return this.$store.getters.loading
            },
            surcharge() {
                return (this.booking.total - this.booking.prepay).toFixed(2)
            },
            priceChanged() {
                return this.initial_total !== this.booking.total;
            }
        },
        watch: {
            "booking.total"() {
                return this.booking.prepay = this.booking.total * this.initial_prepay_percent / 100;
            }
        },
        filters: {
            readableDate(value) {
                return moment(value).format('DD MMMM YYYY');
            },
            moneyFilter(value) {
                return parseFloat(value).toFixed(2);
            }
        },
        methods: {
            onFormSubmit() {
                this.queryLoading = true;
                axios.post(this.formAction, this.booking)
                    .then((response) => {
                        if (response.data.message) {
                            this.$toasted.success(response.data.message)
                        }
                        if (response.data.excursionBooking) {
                            this.booking = response.data.excursionBooking;
                        }
                        this.queryLoading = false
                    })
                    .catch((error) => {
                        if (error.response.data.message) {
                            this.$toasted.error(error.response.data.message)
                        } else {
                            this.$toasted.error(error)
                        }
                        this.queryLoading = false
                    })
            },
        },
        created() {
            this.initial_prepay_percent = this.initialBooking.prepay / this.initialBooking.total * 100;
            this.initial_total = this.initialBooking.total;
            // self.$store.dispatch('receiveLoading', true);
            document.addEventListener("DOMContentLoaded", () => {
                moment.locale(document.documentElement.lang);
                // self.user_partner = window.excursion.user;
                // self.partner = window.excursion.partner;
                // self.place = window.excursion.place;
                // self.booking = window.booking;
                // self.customer = window.booking.customer;
                // self.$store.dispatch('receiveLoading', false)

            })
        }
    }
</script>
