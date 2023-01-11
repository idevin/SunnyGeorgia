<template>
    <div>
        <form class="form" @submit.prevent="xhrSendNumber()">
            <div>
                <div class="input-group mb-8 form-group">
                    <div class="input-group-prepend">
                        <div class="country-code">
                            <multiselect v-model="phone_number.country"
                                         :options="countries"
                                         :custom-label="customLabel"
                                         placeholder="+ code"
                                         label="name"
                                         @select="countrySelect"
                                         track-by="name">
                                <template slot="singleLabel" slot-scope="{ option }">
                                    <div class="flag-box">
                                        <span :class="'option__image-span flag flag-icon-' + (option.code.toLowerCase())"></span>
                                    </div>
                                    <span class="option__title">{{ option.dial_code}}</span>
                                </template>

                                <template slot="option" slot-scope="props">
                                    <div class="option__desc">
                                        <div class="flag-box">
                                            <span :class="'option__image-span flag flag-icon-' + (props.option.code.toLowerCase())"></span>
                                        </div>

                                        <span class="option__title">{{ props.option.name }}</span>
                                        <span class="option__small">{{ props.option.dial_code }}</span>
                                    </div>
                                </template>
                            </multiselect>
                        </div>
                    </div>
                    <input
                            ref="input_mobile"
                            type="tel"
                            class="form-control country-code__phone"
                            :class="{'is-invalid': !phoneIsInInterFormat, 'is-valid': phoneIsInInterFormat}"
                            id="mobile_phone"
                            name="mobile_phone"
                            v-model="phone_number.number"
                            v-validate="'required|regex:^\\+?\\d+$'"
                            @keypress="isNumber"
                            placeholder="Phone number">

                </div>
                <transition name="fade">
                    <div v-if="msg"
                         class="alert"
                         :class="{'alert-danger': !status, 'alert-success': status}"
                         role="alert">{{msg}}
                    </div>
                </transition>

            </div>

            <div class="form__item form-group d-flex justify-content-end">
                <button v-if="timer" type="button" class="btn btn-light">{{timer}}</button>
                <button
                        class="btn btn-primary"
                        :disabled="!phoneIsInInterFormat || timer"
                        type="submit"
                >Send SMS confirmation code
                    <i v-if="sendsms_loading" class="fa fa-spinner fa-spin"></i>
                </button>
            </div>

        </form>
        <form v-if="showSMS" class="form" @submit.prevent="xhrVerification()">
            <div class="form__item form-group">
                <label for="verification_code" class="col-form-label">4 digit code from sms</label>
                <input
                        class="form-control"
                        :class="{'input': true, 'is-danger': errors.has('form-3.signup-code') }"
                        type="text"
                        maxlength="4"
                        name="code"
                        @keypress="isNumber"
                        id="verification_code"
                        v-model="smsCode"
                        v-validate="'required'"
                        autocomplete="off"
                        required
                >
            </div>
            <div class="form__item form-group d-flex justify-content-end">
                <button
                        class="btn btn-primary"
                        type="submit"
                >Confirm
                </button>
            </div>
        </form>
    </div>
</template>

<script>
    import Multiselect from 'vue-multiselect';

    import {parseNumber, isValidNumber} from 'libphonenumber-js'

    export default {
        props: ['formAction', 'verificationAction', 'returnAction', 'defaultCode'],
        data() {
            return {
                timer: null,
                sendsms_loading: false,
                phone_number: {
                    country: null,
                    number: null
                },
                correct_phone_number: null,
                phoneIsInInterFormat: null,
                localCountries: [],
                showSMS: false,
                smsCode: null,
                selectCode: '',
                currentStep: 2,
                status: false,
                msg: null,
                countries: [],
            }
        },
        methods: {
            countrySelect() {
                this.$refs.input_mobile.focus()
            },
            countryNameFormatter(string) {
                var str = string.toLowerCase();
                return str.charAt(0).toUpperCase() + str.slice(1);
            },
            customLabel({name, dial_code}) {
                return `${name} ${dial_code}`
            },
            isNumber(evt) {
                evt = (evt) ? evt : window.event;
                var charCode = (evt.which) ? evt.which : evt.keyCode;
                if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 46) {
                    evt.preventDefault();
                } else {
                    return true;
                }
            },
            numberValidate() {
                var str = this.phone_number.country.dial_code + '' + this.phone_number.number;
                console.log(str);
                if (isValidNumber(str, this.phone_number.country.code)) {
                    this.phoneIsInInterFormat = true

                    this.correct_phone_number = parseNumber(str, this.phone_number.country.code);
                    console.log(this.correct_phone_number.phone);
                    console.log(this.phone_number.country.dial_code);
                } else {
                    this.phoneIsInInterFormat = false
                }

            },
            runTimer(val) {
                if (!this.timer) {
                    this.timer = val;
                    setInterval(() => {
                        if (this.timer > 0) {
                            this.timer = this.timer - 1;
                        } else if (this.timer == 0) {
                            this.timer = null;
                        }
                    }, 1000);
                }
            },
            xhrSendNumber() {
                self = this;
                this.sendsms_loading = true;
                this.status = false;
                this.msg = null;
                this.runTimer(30);
                axios.post(this.formAction, {
                    mobile: this.phone_number.country.dial_code + this.correct_phone_number.phone
                }).then(function (response) {
                    if (response.data.success) {
                        self.showSMS = true;
                    }
                    self.status = response.data.success;
                    self.msg = response.data.message;

                }).catch(function (error) {
                    self.msg = error.message;
                });
                self.sendsms_loading = false;

            },
            xhrVerification() {
                self = this;
                axios.post(this.verificationAction, {
                    code: this.smsCode
                }).then(function (response) {

                    console.log(response);
                    alert('confirmed');
                    window.location = self.returnAction;

                }).catch(function (error) {
                    self.status = false;
                    self.msg = error.message;
                    console.log(error);
                });

            }
        },
        watch: {
            "phone_number.country": function (val) {
                this.numberValidate();
            },
            "phone_number.number": function (val) {
                this.numberValidate();
            },
        },
        components: {
            Multiselect
        },
        created() {
            if (window.composer_countries) {
                this.localCountries = window.composer_countries;
            }
            for (let item in this.localCountries) {
                this.countries.push({
                    code: item,
                    dial_code: "+" + this.localCountries[item].code,
                    name: this.countryNameFormatter(this.localCountries[item].name)
                })
                if (item == this.defaultCode) {
                    this.phone_number.country = {
                        code: item,
                        dial_code: "+" + this.localCountries[item].code,
                        name: this.countryNameFormatter(this.localCountries[item].name)
                    }
                }
            }


        }
    }
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<style>

    .flag-box {
        display: inline-block;
        margin-right: 6px;
    }

    .country-code .multiselect__content-wrapper {
        width: 400px;
    }

    .country-code .option__image-span {
        display: inline-block;
        width: 14px;
        height: 10px;
        background-size: cover;
    }

    .country-code .multiselect__tags {
        text-align: right;
    }

    .country-code .multiselect {
        width: 124px;
    }
</style>